<?php

namespace Viabo\shared\domain\valueObjects;

abstract class DecimalValueObject
{

    public function __construct(protected ?float $value)
    {
    }

    public function value(): float
    {
        return empty($this->value) ? 0.0 : $this->value;
    }

}