<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new\payCloud;


use Viabo\backoffice\services\domain\new\Service;
use Viabo\backoffice\services\domain\new\ServiceActive;
use Viabo\backoffice\services\domain\new\ServiceCreateDate;
use Viabo\backoffice\services\domain\new\ServiceCreatedByUser;
use Viabo\backoffice\services\domain\new\ServiceId;
use Viabo\backoffice\services\domain\new\ServiceUpdateByUser;
use Viabo\backoffice\services\domain\new\ServiceUpdateDate;
use Viabo\backoffice\shared\domain\company\CompanyId;

final class PayCloudService extends Service
{
    public function __construct(
        ServiceId                            $id,
        CompanyId                            $companyId,
        ServiceUpdateByUser                  $updateByUser,
        ServiceUpdateDate                    $updateDate,
        ServiceCreatedByUser                 $createdByUser,
        ServiceCreateDate                    $createDate
    )
    {
        parent::__construct(
            $id,
            $companyId,
            $updateByUser,
            $updateDate,
            $createdByUser,
            $createDate,
            ServiceActive::active()
        );
    }

    public static function create(
        string $companyId,
        string $createdByUser,
        string $createDate
    ): static
    {
        return new static(
            ServiceId::random(),
            CompanyId::create($companyId),
            ServiceUpdateByUser::empty(),
            ServiceUpdateDate::empty(),
            ServiceCreatedByUser::create($createdByUser),
            new ServiceCreateDate($createDate)
        );
    }

    protected function type(): string
    {
        return '3';
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
            'updateByUser' => $this->updateByUser->value(),
            'updateDate' => $this->updateDate->value(),
            'createdByUser' => $this->createdByUser->value(),
            'createDate' => $this->createDate->value(),
            'active' => $this->active->value()
        ];
    }
}
