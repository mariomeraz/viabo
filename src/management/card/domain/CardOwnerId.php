<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\management\card\domain\exceptions\CardOwnerIdEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardOwnerId extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CardOwnerIdEmpty();
        }
    }

    public function isNotEmpty(): bool
    {
        return !empty($this->value);
    }

    public function update(string $value): static
    {
        $value = empty($value) ? $this->value : $value;
        return new static($value);
    }
}