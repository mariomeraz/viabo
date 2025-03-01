<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardMain extends StringValueObject
{
    public function value(): string
    {
        return empty($this->value) ? '0' : $this->value;
    }

}