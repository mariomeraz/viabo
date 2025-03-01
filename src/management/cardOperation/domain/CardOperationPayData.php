<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardOperationPayData extends StringValueObject
{
    public function update(array $payData): static
    {
        $value = json_encode($payData);
        return new static($value);
    }
}