<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\domain;


use Viabo\shared\domain\criteria\Criteria;

interface BusinessRepository
{
    public function search(string $businessId): Business|null;

    public function searchCriteria(Criteria $criteria): array;
}