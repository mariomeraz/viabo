<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateExternalAccountCommandHandler implements CommandHandler
{
    public function __construct(private ExternalAccountCreator $creator)
    {
    }

    public function __invoke(CreateExternalAccountCommand $command): void
    {
        $this->creator->__invoke(
            $command->userId,
            $command->interbankCLABE,
            $command->beneficiary,
            $command->rfc,
            $command->alias,
            $command->bankId,
            $command->email,
            $command->phone
        );
    }
}