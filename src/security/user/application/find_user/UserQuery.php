<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_user;


use Viabo\shared\domain\bus\query\Query;

final readonly class UserQuery implements Query
{
    public function __construct(public string $userId, public string $businessId)
    {
    }
}