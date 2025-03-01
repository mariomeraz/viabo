<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\backoffice\company\domain\exceptions\CompanyFiscalPersonTypeEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyFiscalPersonType extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CompanyFiscalPersonTypeEmpty();
        }
    }

    public static function empty(): static
    {
        return new static('0');
    }

    public static function enable(): static
    {
        return new static('1');
    }

    public function update(string|null $value): static
    {
        $value = empty($value) ? '1' : $value;
        return new static($value);
    }

    public function value(): string
    {
        return $this->value;
    }

}