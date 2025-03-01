<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\persistence;


use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filter;
use Viabo\shared\domain\criteria\FilterField;
use Viabo\shared\domain\criteria\OrderBy;

final readonly class DoctrineCriteriaConverter
{
    public function __construct(
        private Criteria $criteria ,
        private array    $criteriaToDoctrineFields = [] ,
        private array    $hydrators = []
    )
    {
    }

    public static function convert(
        Criteria $criteria ,
        array    $criteriaToDoctrineFields = [] ,
        array    $hydrators = []
    ): DoctrineCriteria
    {
        $converter = new self($criteria , $criteriaToDoctrineFields , $hydrators);

        return $converter->convertToDoctrineCriteria();
    }

    private function convertToDoctrineCriteria(): DoctrineCriteria
    {
        $criteria = new DoctrineCriteria(
            $this->buildExpression($this->criteria) ,
            $this->formatOrder($this->criteria) ,
            $this->criteria->offset() ,
            $this->criteria->limit()
        );

        if ($this->criteria->hasFiltersOr()){
            $criteria->andWhere($this->buildExpressionOr($this->criteria));
        }

        return $criteria;
    }

    private function buildExpression(Criteria $criteria): ?CompositeExpression
    {
        if ($criteria->hasFilters()) {
            return new CompositeExpression(
                CompositeExpression::TYPE_AND ,
                array_map($this->buildComparison() , $criteria->plainFilters())
            );
        }

        return null;
    }

    private function buildExpressionOr(Criteria $criteria): CompositeExpression
    {
        return new CompositeExpression(
            CompositeExpression::TYPE_OR,
            array_map($this->buildComparison(), $criteria->filtersOr())
        );
    }

    private function buildComparison(): callable
    {
        return function (Filter $filter): Comparison {
            $field = $this->mapFieldValue($filter->field());
            $value = $this->formatValue($field , $filter);

            return new Comparison($field , $filter->operator()->value, $value);
        };
    }

    private function mapFieldValue(FilterField $field)
    {
        return array_key_exists($field->value() , $this->criteriaToDoctrineFields)
            ? $this->criteriaToDoctrineFields[$field->value()]
            : $field->value();
    }

    private function existsHydratorFor($field): bool
    {
        return array_key_exists($field , $this->hydrators);
    }

    private function hydrate($field , string $value)
    {
        return $this->hydrators[$field]($value);
    }

    private function formatOrder(Criteria $criteria): ?array
    {
        if (!$criteria->hasOrder()) {
            return null;
        }
        return [$this->mapOrderBy($criteria->order()->orderBy()) => $criteria->order()->orderType()->value];
    }

    private function mapOrderBy(OrderBy $field): mixed
    {
        return array_key_exists($field->value(), $this->criteriaToDoctrineFields)
            ? $this->criteriaToDoctrineFields[$field->value()]
            : $field->value();
    }

    private function formatValue(mixed $field , Filter $filter): mixed
    {
        if($filter->operator()->isIN() || $filter->operator()->isNotIN()){
            return explode(',', $filter->value()->value());
        }

        return $this->existsHydratorFor($field)
            ? $this->hydrate($field , $filter->value()->value())
            : $filter->value()->value();
    }
}
