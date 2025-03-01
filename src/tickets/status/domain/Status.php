<?php declare(strict_types=1);


namespace Viabo\tickets\status\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;

final class Status extends AggregateRoot
{
    public function __construct(
        private StatusId     $id ,
        private StatusName   $name ,
        private StatusActive $active
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'name' => $this->name->value() ,
            'active' => $this->active->value()
        ];
    }
}