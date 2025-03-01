<?php declare(strict_types=1);


namespace Viabo\security\user\domain;


use Viabo\security\shared\domain\user\UserEmail;
use Viabo\security\shared\domain\user\UserId;
use Viabo\shared\domain\criteria\Criteria;

interface UserRepository
{
    public function save(User $user): void;

    public function search(string $userId, string $businessId = null): User|null;

    public function searchBy(UserEmail $email): User|null;

    public function searchCriteria(Criteria $criteria): array;

    public function searchView(UserId $userId): UserView|null;

    public function searchViewByCriteria(Criteria $criteria): array;

    public function update(User $user): void;

    public function delete(User $user): void;
}