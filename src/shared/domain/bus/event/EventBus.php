<?php declare(strict_types=1);

namespace Viabo\shared\domain\bus\event;

interface EventBus
{
    public function publish(DomainEvent ...$events);
}