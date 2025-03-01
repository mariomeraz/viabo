<?php declare(strict_types=1);


namespace Viabo\security\user\infrastructure\doctrine;


use Viabo\security\shared\domain\user\UserEmail;
use Viabo\shared\infrastructure\persistence\UuidType;

final class UserEmailType extends UuidType
{
    protected function typeClassName(): string
    {
        return UserEmail::class;
    }
}