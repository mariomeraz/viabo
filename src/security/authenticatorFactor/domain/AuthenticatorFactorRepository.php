<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\domain;


use Viabo\shared\domain\criteria\Criteria;

interface AuthenticatorFactorRepository
{
    public function save(AuthenticatorFactor $authenticator): void;

    public function searchCriteria(Criteria $criteria): array;

}