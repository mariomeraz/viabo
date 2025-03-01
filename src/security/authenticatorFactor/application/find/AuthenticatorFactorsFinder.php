<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\find;


use Viabo\security\authenticatorFactor\domain\AuthenticatorFactor;
use Viabo\security\authenticatorFactor\domain\AuthenticatorFactorRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class AuthenticatorFactorsFinder
{
    public function __construct(private AuthenticatorFactorRepository $repository)
    {
    }

    public function __invoke(string $userId): AuthenticatorFactorResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'userId.value', 'operator' => '=', 'value' => $userId]
        ]);
        $authenticatorFactors = $this->repository->searchCriteria(new Criteria($filters));
        return new AuthenticatorFactorResponse(array_map(function (AuthenticatorFactor $authenticatorFactor) {
            return $authenticatorFactor->toArray();
        }, $authenticatorFactors));
    }
}