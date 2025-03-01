<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CompanyBankAccountEmpty extends DomainError
{

    public function __construct(private readonly string $number)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "No existe una empresa asociada con la cuenta de banco $this->number";
    }
}