<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\backoffice\company\domain\exceptions\CompanyRfcEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyRfc extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CompanyRfcEmpty();
        }
    }

    public static function empty(): static
    {
        return new static('');
    }

    public function update(string $value): static
    {
        return new static($value);
    }

}