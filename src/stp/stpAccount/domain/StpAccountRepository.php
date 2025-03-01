<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\domain;


use Viabo\shared\domain\criteria\Criteria;

interface StpAccountRepository
{
    public function search(string $stpAccountId): StpAccount|null;

    public function searchCriteria(Criteria $criteria): array;

    public function searchByBusiness(string $businessId): StpAccount|null;

    public function searchAll(string $stpAccountActive = '1'): array;

    public function update(StpAccount $stpAccount): void;
}