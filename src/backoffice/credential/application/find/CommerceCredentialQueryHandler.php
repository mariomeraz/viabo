<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\application\find;


use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CommerceCredentialQueryHandler implements QueryHandler
{
    public function __construct(private CredentialFinder $finder)
    {
    }

    public function __invoke(CommerceCredentialQuery $query): Response
    {
        $commerceId = CompanyId::create($query->commerceId);
        return ($this->finder)($commerceId);
    }
}