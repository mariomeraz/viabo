<?php declare(strict_types=1);

namespace Viabo\backoffice\services\application\create;

use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateServicesCommandHandler implements CommandHandler
{
    public function __construct(private ServicesCreator $servicesUpdater)
    {
    }

    public function __invoke(UpdateViaboServicesCommand $command): void
    {
        $this->servicesUpdater->__invoke($command->commerceId , $command->services);
    }
}