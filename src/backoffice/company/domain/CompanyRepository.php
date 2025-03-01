<?php declare(strict_types=1);

namespace Viabo\backoffice\company\domain;

use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\criteria\Criteria;

interface CompanyRepository
{
    public function save(Company $company): void;

    public function search(string $companyId): Company|null;

    public function searchCriteria(Criteria $criteria): array;

    public function searchView(CompanyId $companyId): CompanyProjection|null;

    public function searchViewCriteria(Criteria $criteria): array;

    public function searchCommerceIdBy(string $userId, string $userProfileId): string;

    public function searchCenterCost(string $centerCostsId): CompanyCostCenter|null;

    public function searchUser(string $userId): CompanyUserOld|null;

    public function searchAvailableBankAccount(): CompanyBankAccount|null;

    public function searchAll(): array;

    public function searchFolioLast(): string;

    public function searchByBankAccount(string $bankAccount): Company|null;

    public function searchAdminUsers(string $userId): array;

    public function update(Company $company): void;

    public function delete(Company $company): void;

}