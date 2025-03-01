<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\bus\command;


use Viabo\shared\domain\bus\command\Command;

final class CommandNotRegisteredError extends \RuntimeException
{
    public function __construct(Command $command)
    {
        $commandClass = $command::class;

        parent::__construct("The command <$commandClass> hasn't a command handler associated");
    }
}