<?php declare(strict_types=1);


namespace Viabo\security\api\domain;


use Viabo\shared\domain\criteria\Criteria;

interface ApiRepository
{
    public function searchCriteria(Criteria $criteria): array|null;
}