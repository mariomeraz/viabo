<?php declare(strict_types=1);


namespace Viabo\management\commerceTerminal\domain;


final class TerminalShared
{
    public function __construct(
        private TerminalSharedId   $id ,
        private TerminalId         $terminalId ,
        private TerminalCommerceId $commerceId ,
    )
    {
    }

    public function terminalId(): string
    {
        return $this->terminalId->value();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'terminalId' => $this->terminalId->value() ,
            'commerceId' => $this->commerceId->value()
        ];
    }

}