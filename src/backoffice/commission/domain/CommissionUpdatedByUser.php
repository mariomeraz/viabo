<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain;


use Viabo\shared\domain\valueObjects\UuidValueObject;

final class CommissionUpdatedByUser extends UuidValueObject
{
    public static function empty(): CommissionUpdatedByUser
    {
        $user = self::random();
        $user->value = '';
        return $user;
    }

    public function update(string $value): static
    {
        return new static($value);
    }

}