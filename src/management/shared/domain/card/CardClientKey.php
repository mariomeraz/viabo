<?php declare(strict_types=1);


namespace Viabo\management\shared\domain\card;


use Viabo\management\card\domain\exceptions\CardClientKeyEmpty;
use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardClientKey extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CardClientKeyEmpty();
        }
    }

    public function valueDecrypt(): string
    {
        return Crypt::decrypt($this->value);
    }
}