<?php declare(strict_types=1);


namespace Viabo\backoffice\commerceUser\domain;


use Viabo\shared\domain\criteria\Criteria;

interface CommerceUserRepository
{
    public function save(CommerceUser $commerceUser): void;

    public function searchCriteria(Criteria $criteria): array;

    public function delete(CommerceUser $commerceUser): void;
}