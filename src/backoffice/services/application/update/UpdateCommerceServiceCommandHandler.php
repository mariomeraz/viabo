<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCommerceServiceCommandHandler implements CommandHandler
{
    public function __construct(private CommerceServiceUpdater $updater)
    {
    }

    public function __invoke(UpdateCommerceServiceCommand $command): void
    {
        $this->updater->__invoke(
            $command->commerceId ,
            $command->serviceType,
            $command->serviceActive
        );
    }
}