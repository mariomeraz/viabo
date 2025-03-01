<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\domain;


use Viabo\shared\domain\criteria\Criteria;

interface ExternalAccountRepository
{
    public function save(ExternalAccount $externalAccount): void;

    public function search(string $externalAccountId): ExternalAccount|null;

    public function searchCriteria(Criteria $criteria): array;

    public function update(ExternalAccount $externalAccount): void;
}