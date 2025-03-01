<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\find_users_by_business;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudUsersQuery implements Query
{
    public function __construct(public string $businessId)
    {
    }
}