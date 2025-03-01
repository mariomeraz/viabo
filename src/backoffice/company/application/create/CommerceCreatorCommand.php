<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\create;


final readonly class CommerceCreatorCommand
{
    public function __construct(
        private string $legalRepresentative,
        private string $taxName,
        private string $rfc,
        private string $tradeName,
        private string $employees,
        private string $branchOffices,
        private string $pointSaleTerminal,
        private string $typeCards,
        private string $paymentApi,
        private string $customerCard
    )
    {
    }

    public function getTaxName(): string
    {
        return $this->taxName;
    }

    public function getRfc(): string
    {
        return $this->rfc;
    }

    public function getTradeName(): string
    {
        return $this->tradeName;
    }

    public function getEmployees(): string
    {
        return $this->employees;
    }

    public function getBranchOffices(): string
    {
        return $this->branchOffices;
    }

    public function getLegalRepresentative(): string
    {
        return $this->legalRepresentative;
    }

    public function getPointSaleTerminal(): string
    {
        return $this->pointSaleTerminal;
    }

    public function getTypeCards(): string
    {
        return $this->typeCards;
    }

    public function getPaymentApi(): string
    {
        return $this->paymentApi;
    }

    public function getCustomerCard(): string
    {
        return $this->customerCard;
    }

}