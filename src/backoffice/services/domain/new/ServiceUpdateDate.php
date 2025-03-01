<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class ServiceUpdateDate extends DateTimeValueObject
{
    public static function empty(): static
    {
        $date = self::todayDate();
        $date->value = '0000-00-00 00:00:00';
        return $date;
    }

    public function update(string $date): static
    {
        return new static($date);
    }

    public function value(): string
    {
        return empty($this->value) || $this->value === '0000-00-00 00:00:00' ?
            '0000-00-00 00:00:00' :
            $this->value;
    }
}
