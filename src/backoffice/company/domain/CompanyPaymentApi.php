<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyPaymentApi extends StringValueObject
{
    public static function create(string $value): self
    {
        return new self(!empty($value) ? $value : '0');
    }

    public static function empty(): static
    {
        return new static('0');
    }

    public function update(string $value): static
    {
        $value = empty($value) ? '0' : $value;
        return new static($value);
    }

}