<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardOperationBalance extends StringValueObject
{
    public function hasBalance(): bool
    {
        return !empty(floatval($this->value));
    }
}