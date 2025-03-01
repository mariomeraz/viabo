<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\domain;


use Viabo\shared\domain\criteria\Criteria;

interface SupportReasonRepository
{
    public function save(SupportReason $supportReason): void;

    public function search(string $supportReasonId): SupportReason|null;

    public function searchAll(): array;

    public function searchCriteria(Criteria $criteria): array;
}