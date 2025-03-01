<?php declare(strict_types=1);


namespace Viabo\management\credential\domain;


use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\utils\RandomPassword;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardCredentialPassword extends StringValueObject
{
    public static function random(): static
    {
        $value = RandomPassword::get();
        return new static(Crypt::encrypt($value));
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