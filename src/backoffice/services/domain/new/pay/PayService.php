<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new\pay;


use Viabo\backoffice\services\domain\new\Service;
use Viabo\backoffice\services\domain\new\ServiceActive;
use Viabo\backoffice\services\domain\new\ServiceCreateDate;
use Viabo\backoffice\services\domain\new\ServiceCreatedByUser;
use Viabo\backoffice\services\domain\new\ServiceId;
use Viabo\backoffice\services\domain\new\ServiceUpdateByUser;
use Viabo\backoffice\services\domain\new\ServiceUpdateDate;
use Viabo\backoffice\shared\domain\company\CompanyId;

final class PayService extends Service
{
    public function __construct(
        ServiceId                           $id,
        CompanyId                           $companyId,
        private PayServiceEmployees         $employees,
        private PayServiceBranchOffices     $branchOffices,
        private PayServicePointSaleTerminal $pointSaleTerminal,
        private PayServicePaymentApi        $paymentApi,
        ServiceUpdateByUser                 $updateByUser,
        ServiceUpdateDate                   $updatedDate,
        ServiceCreatedByUser                $createdByUser,
        ServiceCreateDate                   $createDate
    )
    {
        parent::__construct($id, $companyId, $updateByUser, $updatedDate, $createdByUser, $createDate, ServiceActive::active());
    }

    public static function create(
        string $companyId,
        string $employees,
        string $branchOffices,
        string $pointSaleTerminal,
        string $paymentApi,
        string $createdByUser,
        string $createDate
    ): static
    {
        return new static(
            ServiceId::random(),
            CompanyId::create($companyId),
            PayServiceEmployees::create($employees),
            PayServiceBranchOffices::create($branchOffices),
            PayServicePointSaleTerminal::create($pointSaleTerminal),
            PayServicePaymentApi::create($paymentApi),
            ServiceUpdateByUser::empty(),
            ServiceUpdateDate::empty(),
            ServiceCreatedByUser::create($createdByUser),
            new ServiceCreateDate($createDate)
        );
    }

    protected function type(): string
    {
        return '1';
    }

    public function update(array $data): void
    {
        $this->employees = $this->employees->update(strval($data['employees']));
        $this->branchOffices = $this->branchOffices->update(strval($data['branchOffices']));
        $this->pointSaleTerminal = $this->pointSaleTerminal->update(strval($data['pointSaleTerminal']));
        $this->paymentApi = $this->paymentApi->update(strval($data['paymentApi']));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'type' => $this->type(),
            'companyId' => $this->companyId->value(),
            'employees' => $this->employees->value(),
            'branchOffices' => $this->branchOffices->value(),
            'pointSaleTerminal' => $this->pointSaleTerminal->value(),
            'paymentApi' => $this->paymentApi->value(),
            'updateByUser' => $this->updateByUser->value(),
            'updateDate' => $this->updateDate->value(),
            'createdByUser' => $this->createdByUser->value(),
            'createDate' => $this->createDate->value(),
            'active' => $this->active->value()
        ];
    }
}
