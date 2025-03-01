<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardPaynet extends StringValueObject
{
    public function update(mixed $value): static
    {
        $value = empty($value) ? $this->value : strval($value);
        return new static(empty($value) ? '' : $value);
    }

}