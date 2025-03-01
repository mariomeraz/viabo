<?php declare(strict_types=1);


namespace Viabo\shared\domain\bus\event;


interface DomainEventSubscriber
{
    public static function subscribedTo(): array;
}