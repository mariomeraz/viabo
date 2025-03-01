<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new;


use Viabo\backoffice\services\domain\new\stp\ServiceStpBankAccount;
use Viabo\shared\domain\criteria\Criteria;

interface ServiceRepository
{
    public function save(Service $service): void;

    public function search(string $id): Service|null;

    public function searchCriteria(Criteria $criteria): array;

    public function searchServiceCardCloud(Criteria $criteria): array;

    public function searchAvailableBankAccount(string $businessId): ServiceStpBankAccount;

    public function update(Service $service): void;

    public function updateBankAccount(string $bankAccountId): void;

    public function delete(Service $service): void;

}
