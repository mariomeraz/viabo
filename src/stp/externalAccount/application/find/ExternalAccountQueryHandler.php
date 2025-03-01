<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class ExternalAccountQueryHandler implements QueryHandler
{
    public function __construct(private ExternalAccountFinder $finder)
    {
    }

    public function __invoke(ExternalAccountQuery $query): Response
    {
        return $this->finder->__invoke($query->externalAccountId);
    }
}