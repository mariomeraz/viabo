<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\application\find_business_viabo;


use Viabo\backofficeBusiness\business\application\find_business_by_criteria\BusinessFinderByCriteria;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class ViaboBusinessQueryHandler implements QueryHandler
{
    public function __construct(private BusinessFinderByCriteria $finder)
    {
    }

    public function __invoke(ViaboBusinessQuery $query): Response
    {
        $filters = [['field' => 'name.value', 'operator' => '=', 'value' => 'Viabo']];
        return $this->finder->__invoke($filters);
    }
}