<?php declare(strict_types=1);


namespace Viabo\shared\domain\valueObjects;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Stringable;

class UuidValueObject implements Stringable
{

    public function __construct(protected string|null $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public static function random(): static
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    public function value(): string|null
    {
        return $this->value;
    }

    public function equals(UuidValueObject $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function ensureIsValidUuid(string|null $id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new \DomainException('Error Internal 263: Uui Invalid' , 400);
        }
    }
}