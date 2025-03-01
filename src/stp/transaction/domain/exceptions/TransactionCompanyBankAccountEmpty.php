<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class TransactionCompanyBankAccountEmpty extends DomainError
{
    public function __construct(string $message)
    {
        $this->message = $message;
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "La empresa '$this->message' no esta asociada a una cuenta de banco";
    }
}