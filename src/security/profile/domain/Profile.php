<?php declare(strict_types=1);


namespace Viabo\security\profile\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;

final class Profile extends AggregateRoot
{
    public function __construct(
        private ProfileId      $id ,
        private ProfileName    $name ,
        private ProfileLevel   $level ,
        private ProfileUrlInit $urlInit ,
        private ProfileActive  $active
    )
    {
    }

    public function level(): string
    {
        return $this->level->value();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'name' => $this->name->value() ,
            'level' => $this->level->value() ,
            'urlInit' => $this->urlInit->value() ,
            'active' => $this->active->value()
        ];
    }
}