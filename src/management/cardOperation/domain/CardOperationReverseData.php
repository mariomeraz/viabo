<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardOperationReverseData extends StringValueObject
{
    public function update(array $reverseData): static
    {
        $value = json_encode($reverseData);
        return new static($value);
    }
}