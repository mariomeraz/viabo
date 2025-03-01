<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain;


use Viabo\shared\domain\criteria\Criteria;

interface ReceiptRepository
{
    public function save(Receipt $receipt): void;

    public function search(string $receiptId): Receipt|null;

    public function matching(Criteria $criteria): array;

    public function delete(Receipt $receipt): void;
}