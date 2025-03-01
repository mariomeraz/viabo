<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\shared\domain\criteria\Criteria;

interface CardMovementRepository
{
    public function save(CardMovement $cardMovement): void;

    public function saveLog(CardMovementLog $log): void;

    public function matching(Criteria $criteria): array;

    public function matchingView(Criteria $criteria): array;

    public function delete(CardMovement $cardMovement): void;
}
