<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\create;


use Viabo\backoffice\company\domain\CompanyTradeName;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateInformalCommerceCommandHandler implements CommandHandler
{
    public function __construct(private InformalCommerceCreator $creator)
    {
    }

    public function __invoke(CreateInformalCommerceCommand $command): void
    {
        $commerceTradeName = CompanyTradeName::create($command->tradeName);

        $this->creator->__invoke($commerceTradeName);
    }
}