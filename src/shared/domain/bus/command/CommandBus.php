<?php declare(strict_types=1);


namespace Viabo\shared\domain\bus\command;


interface CommandBus
{
    public function dispatch(Command $command): void;
}