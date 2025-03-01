<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\application\create;


use Viabo\backoffice\credential\domain\CredentialCarnetKey;
use Viabo\backoffice\credential\domain\CredentialMainKey;
use Viabo\backoffice\credential\domain\CredentialMasterCardKey;
use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCredentialCommandHandler implements CommandHandler
{
    public function __construct(private CredentialCreator $creator)
    {
    }

    public function __invoke(CreateCredentialCommand $command): void
    {
        $commerceId = CompanyId::create($command->commerceId);
        $credentialKey = CredentialMainKey::create($command->commerceKey);
        $credentialMasterCardKey = new CredentialMasterCardKey($command->masterCardKey);
        $credentialCarnetKey = new CredentialCarnetKey($command->carnetKey);

        ($this->creator)($commerceId , $credentialKey , $credentialMasterCardKey , $credentialCarnetKey);
    }
}