<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class StpAccountCompanyNotExist extends DomainError
{
    private string $account;

    public function __construct(string $account)
    {
        $this->account = $account;
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "No esta asociada la cuenta <$this->account> a ninguna concentradora";
    }
}