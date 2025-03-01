<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\transactions;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class ReverseCardTransactionCommandHandler implements CommandHandler
{
    public function __construct(private ReverseCardTransactionsProcessor $processor)
    {
    }

    public function __invoke(ReverseCardTransactionCommand $command): void
    {
        $this->processor->__invoke();
    }
}