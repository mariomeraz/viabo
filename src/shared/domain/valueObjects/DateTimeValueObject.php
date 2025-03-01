<?php declare(strict_types=1);


namespace Viabo\shared\domain\valueObjects;


use Viabo\shared\domain\utils\DatePHP;

abstract class DateTimeValueObject
{
    public function __construct(protected ?string $value, protected $date = new DatePHP())
    {
        $this->value = $this->setValue($value);
    }

    public static function todayDate(): static
    {
        $date = new DatePHP();
        return new static($date->dateTime());
    }

    public static function formatDateTime(string $value): static
    {
        $value = preg_match(
            "/^(\d{4})-(\d{1,2})-(\d{1,2})\s(\d{1,2}):(\d{1,2}):(\d{1,2})$/",
            $value
        ) ? $value : "$value 00:00:00";

        return new static($value);
    }

    public static function hasFormatDateTime(string $value): false|int
    {
        return preg_match("/^(\d{4})-(\d{1,2})-(\d{1,2})\s(\d{1,2}):(\d{1,2}):(\d{1,2})$/", $value);
    }

    public function value(): string
    {
        self::setDate();
        return empty($this->value) ? '' : $this->date->formatDateTime($this->value);
    }

    public function convertTimestampToDate(string|int $timestamp): void
    {
        $this->value = $this->date->convertTimestampToDate($timestamp);
    }

    protected function setDate(): void
    {
        $this->date = new DatePHP();
    }

    private function setValue(?string $value): ?string
    {
        if ($value === '0000-00-00 00:00:00') {
            $value = '';
        }
        return $value;
    }
}
