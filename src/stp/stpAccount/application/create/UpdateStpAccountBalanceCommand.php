<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateStpAccountBalanceCommand implements Command
{
    public function __construct(public string $company, public bool $stpAccountsDisable)
    {
    }
}