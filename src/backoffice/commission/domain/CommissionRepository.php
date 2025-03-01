<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain;


use Viabo\shared\domain\criteria\Criteria;

interface CommissionRepository
{
    public function save(Commission $commission): void;

    public function search(string $companyId): Commission|null;

    public function searchCriteria(Criteria $criteria): array;

    public function update(Commission $commission): void;

    public function delete(Commission $commission): void;
}