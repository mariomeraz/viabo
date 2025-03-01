<?php declare(strict_types=1);


namespace Viabo\security\profile\domain;


use Viabo\shared\domain\criteria\Criteria;

interface ProfileRepository
{

    public function search(string $profileId): Profile|null;

    public function searchCriteria(Criteria $criteria): array;
}