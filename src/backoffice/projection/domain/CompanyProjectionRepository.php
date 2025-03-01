<?php declare(strict_types=1);

namespace Viabo\backoffice\projection\domain;

use Viabo\shared\domain\criteria\Criteria;

interface CompanyProjectionRepository
{
    public function save(CompanyProjection $company): void;

    public function search(string $companyId): CompanyProjection|null;

    public function searchCriteria(Criteria $criteria): array;

    public function update(CompanyProjection $company): void;

    public function delete(CompanyProjection $company): void;

}