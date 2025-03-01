<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\application\find;


use Viabo\backoffice\credential\domain\services\CredentialCriteriaFinder;
use Viabo\backoffice\shared\domain\company\CompanyId;

final readonly class CredentialFinder
{
    public function __construct(private CredentialCriteriaFinder $finder)
    {
    }

    public function __invoke(CompanyId $commerceId): CredentialResponse
    {
        $credential = ($this->finder)($commerceId);
        return new CredentialResponse($credential->toArray());
    }

}
