<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\domain\services;

use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\management\terminalTransaction\domain\CommercePay;
use Viabo\management\terminalTransaction\domain\exceptions\TerminalTransactionNotExist;
use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;

final readonly class TerminalTransactionFinder
{
    public function __construct(private TerminalTransactionRepository $repository)
    {
    }

    public function __invoke(string $transactionId): CommercePay
    {
        $transaction = $this->repository->search(new CommercePayId($transactionId));

        if (empty($transaction)) {
            throw new TerminalTransactionNotExist();
        }

        return $transaction;
    }
}
