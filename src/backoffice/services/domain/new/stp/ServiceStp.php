<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new\stp;


use Viabo\backoffice\services\domain\new\Service;
use Viabo\backoffice\services\domain\new\ServiceActive;
use Viabo\backoffice\services\domain\new\ServiceCreateDate;
use Viabo\backoffice\services\domain\new\ServiceCreatedByUser;
use Viabo\backoffice\services\domain\new\ServiceId;
use Viabo\backoffice\services\domain\new\ServiceUpdateByUser;
use Viabo\backoffice\services\domain\new\ServiceUpdateDate;
use Viabo\backoffice\shared\domain\company\CompanyId;

final class ServiceStp extends Service
{
    public function __construct(
        ServiceId                           $id,
        CompanyId                           $companyId,
        private ServiceStpAccountId         $stpAccountId,
        private ServiceStpBankAccountId     $bankAccountId,
        private ServiceStpBankAccountNumber $bankAccountNumber,
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
        string $stpAccountId,
        string $bankAccountId,
        string $bankAccountNumber,
        string $createdByUser,
        string $createDate
    ): static
    {
        return new static(
            ServiceId::random(),
            CompanyId::create($companyId),
            ServiceStpAccountId::create($stpAccountId),
            ServiceStpBankAccountId::create($bankAccountId),
            ServiceStpBankAccountNumber::create($bankAccountNumber),
            ServiceUpdateByUser::empty(),
            ServiceUpdateDate::empty(),
            ServiceCreatedByUser::create($createdByUser),
            new ServiceCreateDate($createDate)
        );
    }

    public function bankAccountId(): string
    {
        return $this->bankAccountNumber->value();
    }

    protected function type(): string
    {
        return '4';
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
            'stpAccountId' => $this->stpAccountId->value(),
            'bankAccountId' => $this->bankAccountId->value(),
            'bankAccountNumber' => $this->bankAccountNumber->value(),
            'updateByUser' => $this->updateByUser->value(),
            'updateDate' => $this->updateDate->value(),
            'createdByUser' => $this->createdByUser->value(),
            'createDate' => $this->createDate->value(),
            'active' => $this->active->value()
        ];
    }
}
