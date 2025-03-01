<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class AuthenticatorFactorsQueryHandler implements QueryHandler
{
    public function __construct(public AuthenticatorFactorsFinder $finder)
    {
    }

    public function __invoke(AuthenticatorFactorsQuery $query): Response
    {
        return $this->finder->__invoke($query->userId);
    }
}