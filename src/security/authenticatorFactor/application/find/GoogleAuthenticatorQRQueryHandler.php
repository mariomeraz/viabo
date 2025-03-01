<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class GoogleAuthenticatorQRQueryHandler implements QueryHandler
{
    public function __construct(private GoogleAuthenticatorQRFinder $finder)
    {
    }

    public function __invoke(GoogleAuthenticatorQRQuery $query): Response
    {
        return $this->finder->__invoke($query->userName);
    }
}