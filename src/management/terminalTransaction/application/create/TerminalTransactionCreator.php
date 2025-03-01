<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\create;

use Viabo\management\terminalTransaction\domain\CommercePay;
use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class TerminalTransactionCreator
{
    public function __construct(private TerminalTransactionRepository $repository , private EventBus $bus)
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
        $commercePay = CommercePay::create(
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
        $this->repository->save($commercePay);

        $this->bus->publish(...$commercePay->pullDomainEvents());
    }
}
