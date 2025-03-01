<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\domain\services;


use Viabo\backoffice\credential\domain\Credential;
use Viabo\backoffice\credential\domain\CredentialRepository;
use Viabo\backoffice\credential\domain\exceptions\CredentialNotExist;
use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CredentialCriteriaFinder
{
    public function __construct(private CredentialRepository $repository)
    {
    }

    public function __invoke(CompanyId $commerceId): Credential
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId->value()]
        ]);
        $credential = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($credential)) {
            throw new CredentialNotExist();
        }

        return $credential[0];
    }

}
