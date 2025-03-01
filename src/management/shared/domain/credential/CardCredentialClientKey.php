<?php declare(strict_types=1);


namespace Viabo\management\shared\domain\credential;


use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardCredentialClientKey extends StringValueObject
{
    public static function create(string $value,): static
    {
        return new static(Crypt::encrypt($value));
    }

    public function valueDecrypt(): string
    {
        return Crypt::decrypt($this->value);
    }

    public function update(string $clientKey): static
    {
        return self::create($clientKey);
    }
}