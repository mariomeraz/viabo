<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_user_by_register;


use Viabo\shared\domain\bus\query\Query;

final readonly class UserQueryByRegisterCompany implements Query
{
    public function __construct(public string $username)
    {
    }
}