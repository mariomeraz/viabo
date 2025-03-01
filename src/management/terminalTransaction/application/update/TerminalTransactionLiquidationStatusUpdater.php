<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\update;


use Viabo\management\terminalTransaction\domain\CommercePayReference;
use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;

final readonly class TerminalTransactionLiquidationStatusUpdater
{
    public function __construct(private TerminalTransactionRepository $repository)
    {
    }

    public function __invoke(string $reference , string $liquidationStatusId): void
    {
        $terminalTransaction = $this->repository->searchBy(new CommercePayReference($reference));
        $terminalTransaction->updateLiquidationStatusId($liquidationStatusId);

        $this->repository->update($terminalTransaction);
    }
}