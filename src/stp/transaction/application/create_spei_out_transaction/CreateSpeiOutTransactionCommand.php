<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\create_spei_out_transaction;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateSpeiOutTransactionCommand implements Command
{
    public function __construct(
        public string $userId,
        public string $businessId,
        public string $originBankAccount,
        public array  $destinationsAccounts,
        public string $concept,
        public bool   $internalTransaction
    )
    {
    }
}