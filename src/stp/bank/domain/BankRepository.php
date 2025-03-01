<?php declare(strict_types=1);


namespace Viabo\stp\bank\domain;


use Viabo\shared\domain\criteria\Criteria;

interface BankRepository
{
    public function search(string $bankId): Bank|null;

    public function searchAll(): array;

    public function searchCriteria(Criteria $criteria): array;
}