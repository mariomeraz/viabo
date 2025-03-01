<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain\spei;


use Viabo\backoffice\commission\domain\Commission;
use Viabo\backoffice\commission\domain\CommissionCreateDate;
use Viabo\backoffice\commission\domain\CommissionCreatedByUser;
use Viabo\backoffice\commission\domain\CommissionId;
use Viabo\backoffice\commission\domain\CommissionUpdateDate;
use Viabo\backoffice\commission\domain\CommissionUpdatedByUser;
use Viabo\backoffice\shared\domain\company\CompanyId;

final class CommissionSpei extends Commission
{
    public function __construct(
        CommissionId                     $id,
        CompanyId                        $companyId,
        private CommissionSpeiOut        $speiOut,
        private CommissionSpeiIn         $speiIn,
        private CommissionSpeiInternal   $internal,
        private CommissionSpeiFeeStp     $feeStp,
        private CommissionSpeiStpAccount $stpAccount,
        CommissionUpdatedByUser          $updatedByUser,
        CommissionUpdateDate             $updateDate,
        CommissionCreatedByUser          $createdByUser,
        CommissionCreateDate             $createDate
    )
    {
        parent::__construct($id, $companyId, $updatedByUser, $updateDate, $createdByUser, $createDate);
    }

    public static function create(
        string $companyId,
        float  $speiOut,
        float  $speiIn,
        float  $internal,
        float  $feeStp,
        string $createdByUser,
        string $createDate
    )
    {
        return new static(
            CommissionId::random(),
            CompanyId::create($companyId),
            CommissionSpeiOut::create($speiOut),
            CommissionSpeiIn::create($speiIn),
            CommissionSpeiInternal::create($internal),
            CommissionSpeiFeeStp::create($feeStp),
            CommissionSpeiStpAccount::empty(),
            CommissionUpdatedByUser::empty(),
            CommissionUpdateDate::empty(),
            CommissionCreatedByUser::create($createdByUser),
            CommissionCreateDate::create($createDate)
        );
    }


    public function update(array $data): void
    {
        $this->speiOut = $this->speiOut->update($data['commissions']['speiOut']);
        $this->speiIn = $this->speiIn->update($data['commissions']['speiIn']);
        $this->internal = $this->internal->update($data['commissions']['internal']);
        $this->feeStp = $this->feeStp->update($data['commissions']['feeStp']);
        $this->updatedByUser = $this->updatedByUser->update($data['updatedByUser']);
        $this->updateDate = $this->updateDate->update($data['updateDate']);
    }

    protected function type(): string
    {
        return '2';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'type' => $this->type(),
            'companyId' => $this->companyId->value(),
            'speiOut' => $this->speiOut->value(),
            'speiIn' => $this->speiIn->value(),
            'internal' => $this->internal->value(),
            'feeStp' => $this->feeStp->value(),
            'stpAccount' => $this->stpAccount->value(),
            'updateByUser' => $this->updatedByUser->value(),
            'updateDate' => $this->updateDate->value(),
            'createdByUser' => $this->createdByUser->value(),
            'createDate' => $this->createDate->value()
        ];
    }
}