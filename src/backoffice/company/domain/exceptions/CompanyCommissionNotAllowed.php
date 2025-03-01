<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CompanyCommissionNotAllowed extends DomainError
{
    public function __construct(private readonly float $commission)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "La comision < Feet Stp > no puede superior a $$this->commission";
    }
}