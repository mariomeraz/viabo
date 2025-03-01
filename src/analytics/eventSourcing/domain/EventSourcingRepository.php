<?php declare(strict_types=1);


namespace Viabo\analytics\eventSourcing\domain;


interface EventSourcingRepository
{
    public function save(EventSourcing $eventSourcing): void;

}