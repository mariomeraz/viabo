<?php declare(strict_types=1);


namespace Viabo\security\code\domain;


use Viabo\security\shared\domain\user\UserId;
use Viabo\shared\domain\criteria\Criteria;

interface CodeRepository
{
    public function save(Code $code): void;

    public function search(string $userId): Code|null;

    public function searchCriteria(Criteria $criteria): Code|null;

    public function delete(Code $code): void;
}