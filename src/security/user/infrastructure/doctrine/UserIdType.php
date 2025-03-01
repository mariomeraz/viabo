<?php declare(strict_types=1);


namespace Viabo\security\user\infrastructure\doctrine;


use Viabo\security\shared\domain\user\UserId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class UserIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return UserId::class;
    }
}