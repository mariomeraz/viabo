<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardSpei extends StringValueObject
{
    public function update(?string $value): static
    {
        $value = empty($value) ? $this->value : $value;
        return new static($value);
    }
}