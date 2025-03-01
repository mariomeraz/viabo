<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCommissionsCommandHandler implements CommandHandler
{
    public function __construct(private CommissionRecorder $recorder)
    {
    }

    public function __invoke(CreateCommissionsCommand $command): void
    {
        $this->recorder->__invoke(
            $command->userId ,
            $command->commerceId ,
            $command->speiInCarnet ,
            $command->speiInMasterCard ,
            $command->speiOutCarnet ,
            $command->speiOutMasterCard ,
            $command->pay ,
            $command->sharedTerminal
        );
    }
}