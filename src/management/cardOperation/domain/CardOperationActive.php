<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardOperationActive extends StringValueObject
{
    public function update(string $value): static
    {
        return new static($value);
    }
}