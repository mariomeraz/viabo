<?php declare(strict_types=1);


namespace Viabo\security\user\domain;


use Viabo\security\user\domain\exceptions\UserLastnameEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserLastname extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new UserLastnameEmpty();
        }
    }

    public function update(string $value): static
    {
        $value = empty($value) ? $this->value : $value;
        return new static($value);
    }
}