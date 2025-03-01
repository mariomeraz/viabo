<?php declare(strict_types=1);


namespace Viabo\security\user\domain;


use Viabo\security\user\domain\exceptions\UserNameEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserName extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    private static function validate(?string $value): void
    {
        if (empty($value)) {
            throw new UserNameEmpty();
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