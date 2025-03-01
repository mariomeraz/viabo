<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\backoffice\company\domain\exceptions\CompanyFiscalNameEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyFiscalName extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CompanyFiscalNameEmpty();
        }
    }

    public static function empty(): static
    {
        return new static('');
    }

    public function update(string $value): static
    {
        $value = empty($value) ? $this->value : $value;
        return new static($value);
    }

}