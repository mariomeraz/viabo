<?php declare(strict_types=1);

namespace Viabo\backoffice\projection\domain;

use Viabo\shared\domain\aggregate\AggregateRoot;

final class CompanyProjection extends AggregateRoot
{

    public function __construct(
        private string  $id,
        private string  $folio,
        private string  $type,
        private string  $typeName,
        private string  $businessId,
        private string  $fatherId,
        private string  $fiscalPersonType,
        private string  $fiscalName,
        private string  $tradeName,
        private string  $rfc,
        private string  $postalAddress,
        private string  $phoneNumbers,
        private string  $logo,
        private string  $slug,
        private float   $balance,
        private string  $statusId,
        private string  $statusName,
        private ?string $registerStep,
        private string  $users,
        private string  $services,
        private string  $documents,
        private string  $commissions,
        private string  $costCenters,
        private string  $updatedByUser,
        private string  $updateDate,
        private string  $createdByUser,
        private string  $createDate,
        private string  $active)
    {
    }

    public static function create(array $values): static
    {
        $values['users'] = empty($values['users']) ? '[]' : json_encode($values['users']);
        $values['commissions'] = empty($values['commissions']) ? '[]' : json_encode($values['commissions']);
        $values['costCenters'] = empty($values['costCenters']) ? '[]' : json_encode($values['costCenters']);
        return new static($values['id'], $values['folio'], $values['type'], $values['typeName'] ?? '', $values['businessId'], $values['fatherId'], $values['fiscalPersonType'], $values['fiscalName'], $values['tradeName'], $values['rfc'], $values['postalAddress'], $values['phoneNumbers'], $values['logo'], $values['slug'], $values['balance'], $values['statusId'], $values['statusName'] ?? '', $values['registerStep'], $values['users'], $values['services'] ?? '[]', $values['documents'] ?? '[]', $values['commissions'], $values['costCenters'], $values['updatedByUser'], $values['updateDate'], $values['createdByUser'], $values['createDate'], $values['active']);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function status(): string
    {
        return $this->statusId;
    }

    public function balance(): float
    {
        return $this->balance;
    }

    public function fiscalName(): string
    {
        return $this->fiscalName;
    }

    public function updateStatusNameAndTypeName(string $typeName, string $statusName): void
    {
        $this->typeName = $typeName;
        $this->statusName = $statusName;
    }

    public function hasUserProfileOfType(string $profileId): bool
    {
        $users = array_filter($this->users(), function (array $user) use ($profileId) {
            return strval($user['profile']) === $profileId;
        });
        return !empty($users);
    }

    public function updateUsers(array $users): void
    {
        $this->users = empty($users) ? '[]' : json_encode($users);
    }

    private function users(): array
    {
        $users = json_decode($this->users, true);
        return array_map(function (array $user) {
            $user['profileId'] = $user['profile'];
            return $user;
        }, $users);
    }

    public function updateServices(array $services): void
    {
        $this->services = empty($services) ? '[]' : json_encode($services);
    }

    public function services(): array
    {
        $services = json_decode($this->services, true);
        return array_map(function (array $service) {
            unset($service['updateByUser'], $service['updateDate'], $service['createdByUser'], $service['createDate']);
            $service['cardNumbers'] = $service['numbers'] ?? '0';
            $service['cardUse'] = $service['purpose'] ?? '0';
            $service['stpAccountId'] = $service['stpAccountId'] ?? '';
            return $service;
        }, $services);
    }

    public function cardCloudServiceSubAccountId(): string
    {
        $services = array_filter(json_decode($this->services, true), function (array $service) {
            $cardCloudServiceType = '5';
            return $service['type'] === $cardCloudServiceType;
        });
        $cardCloudService = [];
        array_map(function (array $service) use (&$cardCloudService) {
            $cardCloudService['subAccountId'] = $service['subAccountId'];
        }, $services);
        return $cardCloudService['subAccountId'] ?? '';
    }

    public function cardCloudServiceData(): array
    {
        return ['id' => $this->id, 'businessId' => $this->businessId, 'fiscalName' => $this->fiscalName, 'tradeName' => $this->tradeName, 'rfc' => $this->rfc, 'subAccountId' => $this->cardCloudServiceSubAccountId(), 'updatedByUser' => $this->updatedByUser, 'updateDate' => $this->updateDate, 'createdByUser' => $this->createdByUser, 'createDate' => $this->createDate, 'active' => $this->active];
    }

    public function updateDocuments(array $documents): void
    {
        $this->documents = json_encode($documents);
    }

    private function documents(): array
    {
        $documents = json_decode($this->documents, true);
        return array_map(function (array $document) {
            return ['Id' => $document['id'], 'Name' => $document['name'], 'storePath' => $document['storePath']];
        }, $documents);
    }

    private function commissions(): array
    {
        return json_decode($this->commissions, true);
    }

    public function updateCommissions(array $commissions): void
    {
        $this->commissions = empty($commissions) ? '[]' : json_encode($commissions);
    }

    public function updateCostCenters(array $costCenters): void
    {
        $costCenters = array_map(function (array $costCenter) {
            return ['id' => $costCenter['id'], 'name' => $costCenter['name']];
        }, $costCenters);
        $this->costCenters = empty($costCenters) ? '[]' : json_encode($costCenters);
    }

    public function updateByClient(string $fiscalPersonType, string $fiscalName, string $tradeName, string $rfc, string $registerStep,): void
    {
        $this->fiscalPersonType = $fiscalPersonType;
        $this->fiscalName = $fiscalName;
        $this->tradeName = $tradeName;
        $this->rfc = $rfc;
        $this->registerStep = $registerStep;
    }

    public function updateBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    public function updateByAdminStp(string $fiscalName, string $tradeName, string $updatedByUser, string $updateDate): void
    {
        $this->fiscalName = $fiscalName;
        $this->tradeName = $tradeName;
        $this->updatedByUser = $updatedByUser;
        $this->updateDate = $updateDate;
    }

    public function updateActive(string $active): void
    {
        $this->active = $active;
    }

    public function hasNotCompletedRegistration(): bool
    {
        return intval($this->registerStep) < 4;
    }

    public function hasServiceSpei(): bool
    {
        $serviceSpei = '4';
        return in_array($serviceSpei, $this->serviceTypes());
    }

    public function hasCardCloudService(): bool
    {
        $cardCloudService = '5';
        return in_array($cardCloudService, $this->serviceTypes());
    }

    public function serviceTypes(): array
    {
        $typeIds = [];
        foreach ($this->services() as $service) {
            if (!in_array($service['type'], $typeIds)) {
                $typeIds[] = $service['type'];
            }
        }
        return $typeIds;
    }

    private function commissionsStp(): array
    {
        $commissions = $this->commissions();
        $commissionStp = array_filter($commissions, function (array $commission) {
            $stpType = '2';
            return $commission['type'] === $stpType;
        });
        if (empty($commissionStp)) {
            return ['speiOut' => 0, 'speiIn' => 0, 'internal' => 0, 'feeStp' => 0, 'stpAccount' => 0];
        }
        unset($commissionStp[0]['id'], $commissionStp[0]['type'], $commissionStp[0]['companyId'], $commissionStp[0]['createdByUser'], $commissionStp[0]['createDate'], $commissionStp[0]['updateByUser'], $commissionStp[0]['updateDate']);
        return $commissionStp[0];

    }

    private function costCenters()
    {
        return json_decode($this->costCenters, true);
    }

    private function stpAccountId(): string
    {
        $services = $this->services();
        $serviceStp = array_filter($services, function (array $service) {
            $stpType = '4';
            return $service['type'] === $stpType;
        });
        return empty($serviceStp) ? '' : $serviceStp[0]['stpAccountId'];
    }

    private function bankAccounts(): array
    {
        $services = $this->services();
        $serviceStp = array_filter($services, function (array $service) {
            $stpType = '4';
            return $service['type'] === $stpType;
        });
        return empty($serviceStp) ? [] : [$serviceStp[0]['bankAccountNumber']];
    }

    private function bankAccount(): string
    {
        $bankAccounts = $this->bankAccounts();
        return empty($bankAccounts) ? '' : strval($bankAccounts[0]);
    }

    public function isBankAccount(string $bankAccount): bool
    {
        $bankAccounts = $this->bankAccounts();
        return in_array($bankAccount, $bankAccounts);
    }

    public function adminEmails(): array
    {
        $users = $this->users();
        $admins = array_filter($users, function (array $user) {
            return $user['profileId'] === '7';
        });
        return array_map(fn(array $user): string => $user['email'], $admins);
    }

    public function adminCompaniesUsers(): array
    {
        $users = $this->users();
        return array_filter($users, function (array $user) {
            return $user['profileId'] === '7';
        });
    }

    public function cardOwners(): array
    {
        $users = $this->users();
        $cardOwners = array_values(array_filter($users, function (array $user) {
            return $user['profileId'] === '8';
        }));
        return array_map(fn(array $user): array => ['id' => $user['id'], 'name' => "{$user['name']} {$user['lastname']}"], $cardOwners);
    }

    public function hasNotServiceType(string $serviceId): bool
    {
        $services = $this->serviceTypes();
        return !in_array($serviceId, $services);
    }

    public function service(string $serviceId): array
    {
        $services = $this->services();
        $service = array_values(array_filter($services, function (array $service) use ($serviceId) {
            return $service['type'] === $serviceId;
        }));
        return $service[0] ?? [];
    }

    public function cardCloudSubAccount(): string
    {
        $services = $this->services();
        $serviceCardCloud = array_values(array_filter($services, function (array $service) {
            return $service['type'] === '5';
        }));
        return empty($serviceCardCloud) ? '' : $serviceCardCloud[0]['subAccountId'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'folio' => $this->folio,
            'type' => $this->type,
            'typeName' => $this->typeName,
            'businessId' => $this->businessId,
            'fatherId' => $this->fatherId,
            'fiscalPersonType' => $this->fiscalPersonType,
            'fiscalName' => $this->fiscalName,
            'tradeName' => $this->tradeName,
            'rfc' => $this->rfc,
            'postalAddress' => $this->postalAddress,
            'phoneNumbers' => $this->phoneNumbers,
            'logo' => $this->logo,
            'slug' => $this->slug,
            'balance' => $this->balance,
            'statusId' => $this->statusId,
            'statusName' => $this->statusName,
            'registerStep' => $this->registerStep,
            'users' => $this->users(),
            'services' => $this->services(),
            'documents' => $this->documents(),
            'commissions' => $this->commissions(),
            'costCenters' => $this->costCenters(),
            'updatedByUser' => $this->updatedByUser,
            'updateDate' => $this->updateDate,
            'createdByUser' => $this->createdByUser,
            'createDate' => $this->createDate,
            'active' => $this->active
        ];
    }

    public function toArrayOld(): array
    {
        $admin = $this->users();
        $services = $this->services();
        $commissions = $this->commissionsStp();
        $stpAccountId = $this->stpAccountId();
        return [
            'id' => $this->id,
            'businessId' => $this->businessId,
            'folio' => $this->folio,
            'fatherId' => $this->fatherId,
            'legalRepresentative' => $admin[0]['id'],
            'legalRepresentativeName' => $admin[0]['name'],
            'legalRepresentativeEmail' => $admin[0]['email'],
            'legalRepresentativePhone' => '',
            'legalRepresentativeRegister' => '',
            'legalRepresentativeLastSession' => '',
            'fiscalPersonType' => $this->fiscalPersonType,
            'fiscalName' => $this->fiscalName ?? '',
            'tradeName' => $this->tradeName,
            'rfc' => $this->rfc,
            'postalAddress' => $this->postalAddress,
            'phoneNumbers' => $this->phoneNumbers,
            'logo' => $this->logo,
            'slug' => $this->slug,
            'balance' => $this->balance,
            'bankAccount' => $this->bankAccount(),
            'bankAccounts' => $this->bankAccounts(),
            'publicTerminal' => '',
            'employees' => $services[0]['employees'] ?? '0',
            'branchOffices' => $services[0]['branchOffices'] ?? '0',
            'pointSaleTerminal' => $services[0]['pointSaleTerminal'] ?? '0',
            'paymentApi' => $services[0]['paymentApi'] ?? '0',
            'type' => $this->type,
            'typeName' => $this->typeName,
            'allowTransactions' => '',
            'statusId' => $this->statusId,
            'statusName' => $this->statusName,
            'stpAccountId' => $stpAccountId,
            'registerStep' => $this->registerStep,
            'users' => $this->users(),
            'services' => $services,
            'servicesIds' => [],
            'costCenters' => $this->costCenters(),
            'documents' => $this->documents(),
            'commissions' => $commissions,
            'speiCommissions' => $commissions,
            'createdByUser' => $this->createdByUser,
            'register' => $this->createDate,
            'active' => $this->active
        ];
    }

}
