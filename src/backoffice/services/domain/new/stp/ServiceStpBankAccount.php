<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new\stp;


final class ServiceStpBankAccount
{
    public function __construct(
        private string $id,
        private string $businessId,
        private string $number,
        private string $available
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function number(): string
    {
        return $this->number;
    }

    public function disable(): void
    {
        $this->available = '0';
    }

    public function enable(): void
    {
        $this->available = '1';
    }
}