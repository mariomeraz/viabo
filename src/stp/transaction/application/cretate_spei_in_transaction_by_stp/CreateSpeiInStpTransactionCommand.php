<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\cretate_spei_in_transaction_by_stp;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateSpeiInStpTransactionCommand implements Command
{
    public function __construct(
        public int    $date,
        public string $company,
        public bool   $stpAccountsDisable
    )
    {
    }
}