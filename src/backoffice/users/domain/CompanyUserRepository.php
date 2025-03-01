<?php declare(strict_types=1);


namespace Viabo\backoffice\users\domain;


use Viabo\backoffice\company\domain\Company;
use Viabo\shared\domain\criteria\Criteria;

interface CompanyUserRepository
{
    public function save(CompanyUser $user): void;

    public function search(string $companyId): Company|null;

    public function searchCriteria(Criteria $criteria): array;

    public function delete(CompanyUser $user): void;

    public function update(CompanyUser $user):void;

}
