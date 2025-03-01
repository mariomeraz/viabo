<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\create;


use Viabo\security\authenticatorFactor\domain\AuthenticatorFactor;
use Viabo\security\authenticatorFactor\domain\AuthenticatorFactorRepository;
use Viabo\security\authenticatorFactor\domain\exceptions\AuthenticatorFactorExist;
use Viabo\security\authenticatorFactor\domain\services\ValidateGoogleAuthenticatorCode;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class GoogleAuthenticatorEnabler
{

    public function __construct(
        private AuthenticatorFactorRepository   $repository,
        private ValidateGoogleAuthenticatorCode $validateGoogleAuthenticatorCode
    )
    {
    }

    public function __invoke(string $userId, string $userName, string $secret, string $code): void
    {
        $this->ensureAuthenticator($userId);
        $this->validateGoogleAuthenticatorCode->__invoke($code, $secret, $userName);
        $authenticator = AuthenticatorFactor::fromGoogle($userId, $secret);

        $this->repository->save($authenticator);

    }

    private function ensureAuthenticator(string $userId): void
    {
        $filters = Filters::fromValues([
            ['field' => 'userId.value', 'operator' => '=', 'value' => $userId]
        ]);
        $authenticator = $this->repository->searchCriteria(new Criteria($filters));

        if (!empty($authenticator)) {
            throw new AuthenticatorFactorExist();
        }
    }

}