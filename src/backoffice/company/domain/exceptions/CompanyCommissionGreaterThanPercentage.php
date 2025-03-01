<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CompanyCommissionGreaterThanPercentage extends DomainError
{
    public function __construct(private readonly string $commission, private readonly float $fee)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "La comision <$this->commission> tiene un porcentaje mayor al $this->fee%";
    }
}