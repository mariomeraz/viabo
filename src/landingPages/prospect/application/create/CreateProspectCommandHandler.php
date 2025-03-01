<?php declare(strict_types=1);


namespace Viabo\landingPages\prospect\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateProspectCommandHandler implements CommandHandler
{
    public function __construct(private ProspectCreator $creator)
    {
    }

    public function __invoke(CreateProspectCommand $command): void
    {
        $this->creator->__invoke(
            $command->businessType,
            $command->name,
            $command->lastname,
            $command->company,
            $command->email,
            $command->phone,
            $command->contactMethod
        );
    }
}