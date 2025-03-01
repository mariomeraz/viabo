<?php declare(strict_types=1);


namespace Viabo\security\shared\domain\user;


use Viabo\security\user\domain\exceptions\UserIdEmpty;
use Viabo\shared\domain\valueObjects\UuidValueObject;

final class UserId extends UuidValueObject
{
    public static function empty(): static
    {
        $userId = parent::random();
        $userId->setEmpty();
        return $userId;
    }

    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new UserIdEmpty();
        }
    }

    public function isNotEmpty(): bool
    {
        return !empty($this->value);
    }

    private function setEmpty(): void
    {
        $this->value = '';
    }
}