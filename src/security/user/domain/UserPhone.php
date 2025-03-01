<?php declare(strict_types=1);

namespace Viabo\security\user\domain;

use Viabo\security\user\domain\exceptions\UserPhoneEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserPhone extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new UserPhoneEmpty();
        }
    }

    public function update(string $value): static
    {
        $value = empty($value) ? $this->value : $value;
        return new static($value);
    }
}
