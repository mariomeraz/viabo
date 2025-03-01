<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyCreatedByUser extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }

    public static function create(string $userId): static
    {
        return new static($userId);
    }
}