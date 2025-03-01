<?php declare(strict_types=1);


namespace Viabo\security\session\domain;


use Viabo\shared\domain\criteria\Criteria;

interface SessionRepository
{
    public function save(Session $session): void;

    public function search(string $userId): Session|null;

    public function update(Session $session): void;

    public function matching(Criteria $criteria): array;
}