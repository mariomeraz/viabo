<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyActive extends StringValueObject
{
    public static function enable(): static
    {
        return new static('1');
    }

    public function update(bool $value): static
    {
        $value = empty($value) ? '0' : '1';
        return new static($value);
    }

    public function value(): string
    {
        return empty($this->value) ? '0' : $this->value;
    }
}