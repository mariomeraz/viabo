<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\domain\services;


use Viabo\security\authenticatorFactor\domain\AuthenticatorFactor;
use Viabo\security\authenticatorFactor\domain\AuthenticatorFactorRepository;
use Viabo\security\authenticatorFactor\domain\exceptions\AuthenticatorFactorNotExist;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class AuthenticatorFactorFinder
{
    public function __construct(private AuthenticatorFactorRepository $repository)
    {
    }

    public function __invoke(array $filters): AuthenticatorFactor
    {
        $filters = Filters::fromValues($filters);
        $authenticator = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($authenticator)) {
            throw new AuthenticatorFactorNotExist();
        }

        return $authenticator[0];
    }
}