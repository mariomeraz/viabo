<?php declare(strict_types=1);


namespace Viabo\stp\bank\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;

final class Bank extends AggregateRoot
{
    public function __construct(
        private BankId        $id ,
        private BankCode      $code ,
        private BankShortName $shortName ,
        private BankName      $name ,
        private BankActive    $active
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'code' => $this->code->value() ,
            'shortName' => $this->shortName->value() ,
            'name' => $this->name->value() ,
            'active' => $this->active->value()
        ];
    }
}