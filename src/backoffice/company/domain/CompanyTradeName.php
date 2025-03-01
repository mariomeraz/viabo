<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\backoffice\company\domain\exceptions\CompanyTradeNameEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyTradeName extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }

    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CompanyTradeNameEmpty();
        }
    }

    public function update(string $value, string $registerStep = '0'): static
    {
        if (intval($registerStep) === 3) {
            return self::create($value);
        }

        $value = empty($value) ? $this->value : $value;
        return new static($value);
    }

}