<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\management\card\domain\exceptions\CarCVVEmpty;
use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardCVV extends StringValueObject
{
    public static function create(string $value): static
    {
        self::validate($value);
        return new static(Crypt::encrypt($value));
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CarCVVEmpty();
        }
    }

    public static function empty(string $value): static
    {
        return new static(Crypt::encrypt($value));
    }

    public function valueDecrypt(): string
    {
        return Crypt::decrypt($this->value);
    }

    public function isEmpty(): bool
    {
        return empty($this->valueDecrypt());
    }

    public function isDifferent(string $value): bool
    {
        return $this->valueDecrypt() !== $value;
    }
}