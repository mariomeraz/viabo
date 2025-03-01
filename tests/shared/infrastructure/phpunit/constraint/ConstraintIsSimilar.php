<?php declare(strict_types=1);

namespace Viabo\Tests\shared\infrastructure\phpunit\constraint;

use Viabo\Tests\shared\infrastructure\phpunit\comparator\AggregateRootArraySimilarComparator;
use Viabo\Tests\shared\infrastructure\phpunit\comparator\AggregateRootSimilarComparator;
use Viabo\Tests\shared\infrastructure\phpunit\comparator\DateTimeSimilarComparator;
use Viabo\Tests\shared\infrastructure\phpunit\comparator\DateTimeStringSimilarComparator;
use Viabo\Tests\shared\infrastructure\phpunit\comparator\DomainEventArraySimilarComparator;
use Viabo\Tests\shared\infrastructure\phpunit\comparator\DomainEventSimilarComparator;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

final class ConstraintIsSimilar extends Constraint
{
    public function __construct(private $value, private readonly float $delta = 0.0) {}

    public function evaluate($other, $description = '', $returnResult = false): bool
    {
        if ($this->value === $other) {
            return true;
        }

        $isValid = true;
        $comparatorFactory = new Factory();

        $comparatorFactory->register(new AggregateRootArraySimilarComparator());
        $comparatorFactory->register(new AggregateRootSimilarComparator());
        $comparatorFactory->register(new DomainEventArraySimilarComparator());
        $comparatorFactory->register(new DomainEventSimilarComparator());
        $comparatorFactory->register(new DateTimeSimilarComparator());
        $comparatorFactory->register(new DateTimeStringSimilarComparator());

        try {
            $comparator = $comparatorFactory->getComparatorFor($other, $this->value);
            $comparator->assertEquals($this->value, $other, $this->delta);
        } catch (ComparisonFailure $f) {
            if (!$returnResult) {
                throw new ExpectationFailedException(trim($description . "\n" . $f->getMessage()), $f);
            }
            $isValid = false;
        }

        return $isValid;
    }

    public function toString(): string
    {
        $delta = '';

        if (is_string($this->value)) {
            if (str_contains($this->value, "\n")) {
                return 'is equal to <text>';
            }

            return sprintf("is equal to '%s'", $this->value);
        }

        if ($this->delta !== 0) {
            $delta = sprintf(' with delta <%F>', $this->delta);
        }

        return sprintf('is equal to %s%s', $this->exporter()->export($this->value), $delta);
    }
}