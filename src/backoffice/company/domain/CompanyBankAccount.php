<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


final class CompanyBankAccount
{
    public function __construct(
        private string $id,
        private string $number,
        private string $available
    )
    {
    }

    public function number(): string
    {
        return $this->number;
    }

    public function notAvailable(): void
    {
        $this->available = '0';
    }

    public function available(): void
    {
        $this->available = '1';
    }
}