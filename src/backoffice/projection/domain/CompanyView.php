<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;

final class CompanyView extends AggregateRoot
{
    public function __construct(
        private string  $id,
        private string  $folio,
        private string  $fatherId,
        private string  $legalRepresentative,
        private string  $legalRepresentativeName,
        private string  $legalRepresentativeEmail,
        private string  $legalRepresentativePhone,
        private string  $legalRepresentativeRegister,
        private string  $legalRepresentativeLastSession,
        private string  $fiscalPersonType,
        private string  $fiscalName,
        private string  $tradeName,
        private string  $rfc,
        private string  $postalAddress,
        private string  $phoneNumbers,
        private string  $logo,
        private string  $slug,
        private string  $balance,
        private ?string $bankAccount,
        private string  $publicTerminal,
        private string  $employees,
        private string  $branchOffices,
        private string  $pointSaleTerminal,
        private string  $paymentApi,
        private string  $register,
        private string  $type,
        private string  $typeName,
        private string  $allowTransactions,
        private string  $statusId,
        private string  $statusName,
        private string  $stpAccountId,
        private string  $registerStep,
        private ?string $services,
        private ?string $servicesIds,
        private string  $documents,
        private string  $commissions,
        private ?string $createdByUser,
        private string  $active
    )
    {
    }

    public function hasServiceSpei(): bool
    {
        $serviceSpei = '4';
        return !empty($this->servicesIds) && str_contains($this->servicesIds, $serviceSpei);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'folio' => $this->folio,
            'fatherId' => $this->fatherId,
            'legalRepresentative' => $this->legalRepresentative,
            'legalRepresentativeName' => $this->legalRepresentativeName,
            'legalRepresentativeEmail' => $this->legalRepresentativeEmail,
            'legalRepresentativePhone' => $this->legalRepresentativePhone,
            'legalRepresentativeRegister' => $this->legalRepresentativeRegister,
            'legalRepresentativeLastSession' => empty($this->legalRepresentativeLastSession) ? '' : $this->legalRepresentativeLastSession,
            'fiscalPersonType' => $this->fiscalPersonType,
            'fiscalName' => $this->fiscalName ?? '',
            'tradeName' => $this->tradeName,
            'rfc' => $this->rfc,
            'postalAddress' => $this->postalAddress ?? '',
            'phoneNumbers' => $this->phoneNumbers ?? '',
            'logo' => $this->logo,
            'slug' => $this->slug,
            'balance' => $this->balance,
            'bankAccount' => $this->bankAccount,
            'publicTerminal' => $this->publicTerminal,
            'employees' => $this->employees,
            'branchOffices' => $this->branchOffices,
            'pointSaleTerminal' => $this->pointSaleTerminal,
            'paymentApi' => $this->paymentApi,
            'register' => $this->register,
            'type' => $this->type,
            'typeName' => $this->typeName,
            'allowTransactions' => $this->allowTransactions,
            'statusId' => $this->statusId,
            'statusName' => $this->statusName,
            'stpAccountId' => $this->stpAccountId,
            'registerStep' => $this->registerStep,
            'services' => empty($this->services) ? [] : json_decode("[$this->services]"),
            'servicesIds' => empty($this->servicesIds) ? [] : json_decode("[$this->servicesIds]"),
            'documents' => empty($this->documents) ? [] : json_decode("[$this->documents]"),
            'commissions' => empty($this->commissions) ? null : json_decode("$this->commissions"),
            'createdByUser' => $this->createdByUser,
            'active' => $this->active
        ];
    }

    public function toArrayForCatalog(): array
    {
        return ['id' => $this->id, 'name' => $this->tradeName];
    }

}
