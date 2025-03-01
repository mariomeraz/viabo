<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;
use Viabo\tickets\ticket\domain\exceptions\TicketDescriptionEmpty;
use Viabo\tickets\ticket\domain\exceptions\TicketDescriptionTooLong;

final class TicketDescription extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new TicketDescriptionEmpty();
        }

        $characterLength = strlen($value);
        if ($characterLength > 200) {
            throw new TicketDescriptionTooLong();
        }

    }
}