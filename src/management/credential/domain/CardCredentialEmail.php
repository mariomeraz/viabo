<?php declare(strict_types=1);


namespace Viabo\management\credential\domain;


use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\utils\Faker;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardCredentialEmail extends StringValueObject
{
    public static function random(): static
    {
        $value = Faker::userName();
        return new static(Crypt::encrypt("$value@viabo.com"));
    }

    public static function create(string $value): static
    {
        return new static(Crypt::encrypt($value));
    }

    public function valueDecrypt(): string
    {
        return Crypt::decrypt($this->value);
    }
}