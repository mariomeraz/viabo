<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\application\find;

use Viabo\management\terminalTransactionLog\domain\CommercePayTransactionId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CommerceTransactionQueryHandler implements QueryHandler
{
    public function __construct(private CommerceTransactionFinder $finder)
    {
    }

    public function __invoke(CommerceTransactionQuery $query):Response
    {
        $commerceTransaction = new CommercePayTransactionId($query->transactionId);

        return $this->finder->__invoke($commerceTransaction);
    }
}
