<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;
use Viabo\tickets\ticket\domain\exceptions\TicketAssignedProfileIdEmpty;

final class TicketAssignedProfileId extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new TicketAssignedProfileIdEmpty();
        }
    }
}