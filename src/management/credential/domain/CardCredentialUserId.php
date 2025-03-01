<?php declare(strict_types=1);


namespace Viabo\management\credential\domain;


use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardCredentialUserId extends StringValueObject
{
    public function __construct(?string $value)
    {
        parent::__construct(Crypt::encrypt($value));
    }

    public function update(string $value): static
    {
        return new static($value);
    }

    public function valueDecrypt(): string
    {
        try {
            return Crypt::decrypt($this->value);
        } catch (\DomainException) {
            return '';
        }
    }
}