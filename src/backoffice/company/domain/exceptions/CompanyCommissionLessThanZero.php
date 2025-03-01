<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CompanyCommissionLessThanZero extends DomainError
{

    public function __construct(private readonly string $commission)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "La comision <$this->commission> no puede ser menor a cero";
    }
}