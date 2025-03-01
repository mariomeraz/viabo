<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class TicketStatusId extends StringValueObject
{
    public static function new(): static
    {
        return new static('1');
    }

    public function isDifferent(string $newStatus): bool
    {
        return $this->value != $newStatus;
    }

    public function update(string $newStatus): static
    {
        return new static($newStatus);
    }
}