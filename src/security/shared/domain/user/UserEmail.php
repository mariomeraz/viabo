<?php declare(strict_types=1);


namespace Viabo\security\shared\domain\user;


use Viabo\security\user\domain\exceptions\UserEmailEmpty;
use Viabo\security\user\domain\exceptions\UserEmailNoValid;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserEmail extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new UserEmailEmpty();
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new UserEmailNoValid();
        }
    }

    public static function empty(): static
    {
        return new static('');
    }

    public function isNotEmpty(): bool
    {
        return !empty($this->value);
    }

    public function update(string $value): static
    {
        return self::create($value);
    }
}