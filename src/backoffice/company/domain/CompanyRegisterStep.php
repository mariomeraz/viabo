<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\backoffice\company\domain\exceptions\CompanyRegisterStepEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyRegisterStep extends StringValueObject
{
    public static function update(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CompanyRegisterStepEmpty();
        }
    }

    public static function start(): static
    {
        return new static('1');
    }

    public static function concluded(): static
    {
        return new static('4');
    }

    public function isLastStep(): bool
    {
        $lastStep = '4';
        return $this->value === $lastStep;
    }

}