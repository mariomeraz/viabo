<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class TicketApplicantProfileId extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}