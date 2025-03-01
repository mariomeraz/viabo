<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\create;

use Viabo\management\terminalTransaction\domain\CommercePay;
use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;

final readonly class CommercePayVirtualTerminalCreator
{
    public function __construct(private TerminalTransactionRepository $repository)
    {
    }

    public function __invoke(
        string $terminalTransactionId ,
        string $commerceId ,
        string $terminalId ,
        string $clientName ,
        string $email ,
        string $phone ,
        string $description ,
        string $amount ,
        string $userId ,
    ): void
    {
        $transaction = CommercePay::create(
            $terminalTransactionId ,
            $commerceId ,
            $terminalId ,
            $clientName ,
            $email ,
            $phone ,
            $description ,
            $amount ,
            $userId
        );

        $this->repository->save($transaction);
    }
}
