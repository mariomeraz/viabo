<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\application\create;


use Viabo\backoffice\company\application\find\CommerceQuery;
use Viabo\backoffice\credential\domain\Credential;
use Viabo\backoffice\credential\domain\CredentialCarnetKey;
use Viabo\backoffice\credential\domain\CredentialMainKey;
use Viabo\backoffice\credential\domain\CredentialMasterCardKey;
use Viabo\backoffice\credential\domain\CredentialRepository;
use Viabo\backoffice\credential\domain\exceptions\CredentialCommerceInformal;
use Viabo\backoffice\credential\domain\services\CredentialValidator;
use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class CredentialCreator
{
    public function __construct(
        private CredentialRepository $repository ,
        private QueryBus             $queryBus ,
        private EventBus             $bus ,
        private CredentialValidator  $validator
    )
    {
    }

    public function __invoke(
        CompanyId               $commerceId ,
        CredentialMainKey       $commerceKey ,
        CredentialMasterCardKey $credentialMasterCardKey ,
        CredentialCarnetKey     $credentialCarnetKey
    ): void
    {
        $this->ensureExist($commerceId);

        $credential = Credential::create($commerceId , $commerceKey , $credentialMasterCardKey , $credentialCarnetKey);

        $this->validator->validateNotExist($credential);

        $this->repository->save($credential);

        $this->bus->publish(...$credential->pullDomainEvents());
    }

    private function ensureExist(CompanyId $commerceId): void
    {
        $data = $this->queryBus->ask(new CommerceQuery($commerceId->value()));

        if ($this->isInformal($data->data)) {
            throw new CredentialCommerceInformal();
        }
    }

    private function isInformal(array $commerce): bool
    {
        $informalType = '2';
        return $commerce['type'] === $informalType;
    }
}