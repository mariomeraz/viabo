<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\management\card\domain\exceptions\CardNipEmpty;
use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardNip extends StringValueObject
{
    public static function create(string $value): static
    {
        self::validate($value);
        return new static(Crypt::encrypt($value));
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CardNipEmpty();
        }
    }

    public static function empty(string $value): static
    {
        if (empty($value)) {
            return new static($value);
        }
        return new static(Crypt::encrypt($value));
    }

    public function valueDecrypt(): string
    {
        return Crypt::decrypt($this->value ?? '');
    }

    public function update(?string $value): static
    {
        if (empty($value)) {
            return new static($this->value);
        }

        if (Crypt::isEncrypt($value)) {
            return new static($value);
        }

        return static::create($value);
    }

}