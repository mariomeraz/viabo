<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\create_spei_out_transaction_by_stp;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateSpeiOutTransactionCommandByStp implements Command
{
    public function __construct(public string $company, public bool $stpAccountsDisable)
    {
    }
}