<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new\card;


use Viabo\backoffice\services\domain\new\Service;
use Viabo\backoffice\services\domain\new\ServiceActive;
use Viabo\backoffice\services\domain\new\ServiceCreateDate;
use Viabo\backoffice\services\domain\new\ServiceCreatedByUser;
use Viabo\backoffice\services\domain\new\ServiceId;
use Viabo\backoffice\services\domain\new\ServiceUpdateByUser;
use Viabo\backoffice\services\domain\new\ServiceUpdateDate;
use Viabo\backoffice\shared\domain\company\CompanyId;

final class CardService extends Service
{
    public function __construct(
        ServiceId                            $id,
        CompanyId                            $companyId,
        private CardServiceEmployees         $employees,
        private CardServiceBranchOffices     $branchOffices,
        private CardServiceNumbers           $numbers,
        private CardServicePurpose           $purpose,
        private CardServicePersonalized      $personalized,
        private CardServiceAllowTransactions $allowTransactions,
        ServiceUpdateByUser                  $updateByUser,
        ServiceUpdateDate                    $updateDate,
        ServiceCreatedByUser                 $createdByUser,
        ServiceCreateDate                    $createDate
    )
    {
        parent::__construct($id, $companyId, $updateByUser, $updateDate, $createdByUser, $createDate, ServiceActive::active());
    }

    public static function create(
        string $companyId,
        string $employees,
        string $branchOffices,
        string $cardNumbers,
        string $cardPurpose,
        string $personalized,
        string $createdByUser,
        string $createDate
    ): static
    {
        return new static(
            ServiceId::random(),
            CompanyId::create($companyId),
            CardServiceEmployees::create($employees),
            CardServiceBranchOffices::create($branchOffices),
            CardServiceNumbers::create($cardNumbers),
            CardServicePurpose::create($cardPurpose),
            CardServicePersonalized::create($personalized),
            CardServiceAllowTransactions::enable(),
            ServiceUpdateByUser::empty(),
            ServiceUpdateDate::empty(),
            ServiceCreatedByUser::create($createdByUser),
            new ServiceCreateDate($createDate)
        );
    }

    protected function type(): string
    {
        return '2';
    }

    public function update(array $data): void
    {
        $this->employees = $this->employees->update(strval($data['employees']));
        $this->branchOffices = $this->branchOffices->update(strval($data['branchOffices']));
        $this->numbers = $this->numbers->update(strval($data['cardNumbers']));
        $this->purpose = $this->purpose->update($data['cardUse']);
        $this->personalized = $this->personalized->update(strval($data['personalized']));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'type' => $this->type(),
            'companyId' => $this->companyId->value(),
            'employees' => $this->employees->value(),
            'branchOffices' => $this->branchOffices->value(),
            'numbers' => $this->numbers->value(),
            'purpose' => $this->purpose->value(),
            'personalized' => $this->personalized->value(),
            'allowTransactions' => $this->allowTransactions->value(),
            'updateByUser' => $this->updateByUser->value(),
            'updateDate' => $this->updateDate->value(),
            'createdByUser' => $this->createdByUser->value(),
            'createDate' => $this->createDate->value(),
            'active' => $this->active->value()
        ];
    }
}
