<?php declare(strict_types=1);

namespace Viabo\backoffice\services\domain\new\cardCloud;

use Viabo\backoffice\services\domain\new\Service;
use Viabo\backoffice\services\domain\new\ServiceActive;
use Viabo\backoffice\services\domain\new\ServiceCreateDate;
use Viabo\backoffice\services\domain\new\ServiceCreatedByUser;
use Viabo\backoffice\services\domain\new\ServiceId;
use Viabo\backoffice\services\domain\new\ServiceUpdateByUser;
use Viabo\backoffice\services\domain\new\ServiceUpdateDate;
use Viabo\backoffice\shared\domain\company\CompanyId;

final class ServiceCardCloud extends Service
{
    public function __construct(
        ServiceId                     $id,
        CompanyId                     $companyId,
        private CardCloudSubAccountId $subAccountId,
        private CardCloudSubAccount   $subAccount,
        ServiceUpdateByUser           $updateByUser,
        ServiceUpdateDate             $updatedDate,
        ServiceCreatedByUser          $createdByUser,
        ServiceCreateDate             $createDate
    )
    {
        parent::__construct($id, $companyId, $updateByUser, $updatedDate, $createdByUser, $createDate, ServiceActive::active());
    }

    public static function create(
        string $companyId,
        string $createdByUser,
        array  $serviceCardCloud
    ): ServiceCardCloud
    {
        return new ServiceCardCloud(
            ServiceId::random(),
            CompanyId::create($companyId),
            CardCloudSubAccountId::create($serviceCardCloud['subaccount_id']),
            CardCloudSubAccount::create(json_encode($serviceCardCloud)),
            ServiceUpdateByUser::empty(),
            ServiceUpdateDate::empty(),
            ServiceCreatedByUser::create($createdByUser),
            ServiceCreateDate::now()
        );
    }

    protected function type(): string
    {
        return '5';
    }

    public function update(array $data): void
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'type' => $this->type(),
            'companyId' => $this->companyId->value(),
            'subAccountId' => $this->subAccountId->value(),
            'subAccount' => $this->subAccount->value(),
            'updateByUser' => $this->updateByUser->value(),
            'updateDate' => $this->updateDate->value(),
            'createdByUser' => $this->createdByUser->value(),
            'createDate' => $this->createDate->value(),
            'active' => $this->active->value()
        ];
    }
}
