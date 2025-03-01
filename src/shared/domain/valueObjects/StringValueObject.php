<?php

namespace Viabo\shared\domain\valueObjects;

abstract class StringValueObject
{

    public function __construct(protected ?string $value)
    {
    }

    public function value(): string
    {
        return empty($this->value) ? '' : $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}