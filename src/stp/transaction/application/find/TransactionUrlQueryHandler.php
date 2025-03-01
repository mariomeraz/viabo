<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TransactionUrlQueryHandler implements QueryHandler
{
    public function __construct(private TransactionUrlFinder $finder)
    {
    }

    public function __invoke(TransactionUrlQuery $query): Response
    {
        return $this->finder->__invoke($query->transactionId);
    }
}