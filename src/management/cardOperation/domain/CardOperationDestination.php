<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardOperationDestination extends StringValueObject
{
    public function last8Digits(): string
    {
        return substr($this->value , -8);
    }
}