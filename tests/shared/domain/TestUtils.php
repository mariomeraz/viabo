<?php declare(strict_types=1);

namespace Viabo\Tests\shared\domain;

use Viabo\Tests\shared\infrastructure\mockery\MatcherIsSimilar;
use Viabo\Tests\shared\infrastructure\phpunit\constraint\ConstraintIsSimilar;

final class TestUtils
{
    public static function isSimilar(mixed $expected, mixed $actual): bool
    {
        $constraint = new ConstraintIsSimilar($expected);

        return $constraint->evaluate($actual, '', true);
    }

    public static function assertSimilar(mixed $expected, mixed $actual): void
    {
        $constraint = new ConstraintIsSimilar($expected);

        $constraint->evaluate($actual);
    }

    public static function similarTo(mixed $value, float $delta = 0.0): MatcherIsSimilar
    {
        return new MatcherIsSimilar($value, $delta);
    }

}