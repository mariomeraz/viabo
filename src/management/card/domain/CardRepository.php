<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\shared\domain\criteria\Criteria;

interface CardRepository
{
    public function save(Card $card): void;

    public function search(string $cardId): Card|null;

    public function searchCriteria(Criteria $criteria): array;

    public function searchCardInformationView(Criteria $criteria):array;

    public function searchView(Criteria $criteria): array;

    public function searchAllView(): array;

    public function update(Card $card): void;
}
