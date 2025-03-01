<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_user_by_id;


use Viabo\shared\domain\bus\query\Query;

final readonly class UserQueryById implements Query
{
    public function __construct(public string $userId)
    {
    }
}