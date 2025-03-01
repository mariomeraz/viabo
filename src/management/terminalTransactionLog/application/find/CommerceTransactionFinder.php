<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\application\find;

use Viabo\management\terminalTransactionLog\domain\CommercePayTransactionId;
use Viabo\management\terminalTransactionLog\domain\CommercePayTransactionRepository;

final readonly class CommerceTransactionFinder
{
    public function __construct(private CommercePayTransactionRepository $repository)
    {
    }

    public function __invoke(CommercePayTransactionId $transactionId):CommerceTransactionResponse
    {
        $commerceTransaction = $this->repository->searchBy($transactionId);

        return new CommerceTransactionResponse($commerceTransaction->toArray());
    }
}
