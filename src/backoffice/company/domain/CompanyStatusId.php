<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyStatusId extends StringValueObject
{
    public static function record(): static
    {
        return new static('1');
    }

    public static function affiliate(): static
    {
        return new static('3');
    }

    public function update(bool $isLastStep): static
    {
        $value = $isLastStep ? '2' : $this->value;
        return new self($value);
    }
}