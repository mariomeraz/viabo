<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\domain;

use Viabo\management\terminalTransaction\domain\exceptions\CommercePayReferenceIdEmpty;
use Viabo\shared\domain\utils\DatePHP;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayReference extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CommercePayReferenceIdEmpty();
        }
    }

    public static function random(): static
    {
        $date = new DatePHP();
        $reference = $date->serializeDate();
        return new static($reference);
    }
}
