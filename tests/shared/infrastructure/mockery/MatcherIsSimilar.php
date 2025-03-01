<?php

declare(strict_types=1);

namespace Viabo\Tests\shared\infrastructure\mockery;

use Mockery\Matcher\MatcherAbstract;
use Viabo\Tests\shared\infrastructure\phpunit\constraint\ConstraintIsSimilar;

final class MatcherIsSimilar extends MatcherAbstract
{
    private ConstraintIsSimilar $constraint;

    public function __construct($value, $delta = 0.0)
    {
        parent::__construct($value);

        $this->constraint = new ConstraintIsSimilar($value, $delta);
    }

    public function match(&$actual): bool
    {
        return $this->constraint->evaluate($actual, '', true);
    }

    public function __toString(): string
    {
        return 'Is similar';
    }
}
