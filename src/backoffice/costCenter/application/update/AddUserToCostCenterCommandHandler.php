<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class AddUserToCostCenterCommandHandler implements CommandHandler
{
    public function __construct(public UserCostCenterAdder $adder)
    {
    }

    public function __invoke(AddUserToCostCenterCommand $command): void
    {
        $this->adder->__invoke($command->costCenterId, $command->userId);
    }
}