<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\criteria\Criteria;

interface TransactionRepository
{
    public function save(Transaction $transaction): void;

    public function search(string $transactionId): Transaction|null;

    public function searchCriteria(Criteria $criteria): array;

    public function searchAll(): array;

    public function searchType(string $id): TransactionTypeId|null;

    public function searchStatus(string $id): TransactionStatusId|null;

    public function searchByAccount(string $initialDate, string $endDate, string $account, string $order, ?int $limit): array;

    public function searchByBusinessId(string $date, string $businessId): array;

    public function update(Transaction $transaction): void;
}