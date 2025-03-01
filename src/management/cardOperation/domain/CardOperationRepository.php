<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\criteria\Criteria;

interface CardOperationRepository
{
    public function save(CardOperations $operations): void;

    public function searchCriteria(Criteria $criteria): array;

    public function searchDateRange(CardNumber $cardNumber , string $initialDate , string $finalDate): array;

    public function searchAll(): array;

    public function update(CardOperations $operations): void;
}