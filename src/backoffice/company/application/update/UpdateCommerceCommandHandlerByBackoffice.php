<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCommerceCommandHandlerByBackoffice implements CommandHandler
{
    public function __construct(private CommerceUpdaterByBackoffice $updater)
    {
    }

    public function __invoke(UpdateCommerceCommandByBackoffice $command): void
    {
        $this->updater->__invoke(
            $command->userId ,
            $command->commerceId ,
            $command->tradeName ,
            $command->fiscalName ,
            $command->rfc ,
            $command->fiscalPersonType ,
            $command->employees ,
            $command->branchOffices ,
            $command->postalAddress ,
            $command->phoneNumbers ,
            $command->slug ,
            $command->publicTerminal ,
            $command->logo
        );
    }
}