<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\domain;


use Viabo\backoffice\credential\domain\exceptions\CredentialMainKeyEmpty;
use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CredentialMainKey extends StringValueObject
{
    public function __construct(?string $value)
    {
        $value = empty($value) ? '' : Crypt::encrypt($value);
        parent::__construct($value);
    }

    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CredentialMainKeyEmpty();
        }
    }

    public function valueDecrypt(): string
    {
        return Crypt::decrypt($this->value);
    }

}