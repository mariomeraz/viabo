<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain;


use Viabo\shared\domain\criteria\Criteria;

interface ServiceRepository
{
    public function save(Service $service): void;

    public function searchCriteria(Criteria $criteria): array;

    public function update(Service $service): void;

    public function delete(string $companyId): void;
}