<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\domain;


use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CredentialCarnetKey extends StringValueObject
{
    public function __construct(?string $value)
    {
        $value = empty($value)?'': Crypt::encrypt($value);
        parent::__construct($value);
    }

    public function valueDecrypt(): string
    {
        return Crypt::decrypt($this->value);
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

}