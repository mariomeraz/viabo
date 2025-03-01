<?php declare(strict_types=1);


namespace Viabo\analytics\eventSourcing\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class EventSourcingBody extends StringValueObject
{
    public static function create(array $value): self
    {
        return new self(json_encode($value));
    }

}