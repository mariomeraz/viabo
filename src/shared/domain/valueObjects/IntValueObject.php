<?php

namespace Viabo\shared\domain\valueObjects;

abstract class IntValueObject
{

    public function __construct(protected ?int $value)
    {
    }

    public function value(): int
    {
        return empty($this->value) ? 0 : $this->value;
    }

}