<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class ReceiptNote extends StringValueObject
{
    public function hasNote(): bool
    {
        return !empty($this->value);
    }
}