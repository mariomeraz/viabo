<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class ExternalAccountsQueryHandler implements QueryHandler
{
    public function __construct(private ExternalAccountsFinder $finder)
    {
    }

    public function __invoke(ExternalAccountsQuery $query): Response
    {
        return $this->finder->__invoke($query->userId);
    }
}