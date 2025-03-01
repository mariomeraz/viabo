<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\shared\domain\Collection;

final class CompanyUsers extends Collection
{

    public static function fromValues(array $values): static
    {
        return new static(array_map(self::CompanyUserBuilder(), $values));
    }

    private static function CompanyUserBuilder(): callable
    {
        return fn(array $values): CompanyUser => CompanyUser::fromValue($values);
    }

    public static function empty(): static
    {
        return new static([]);
    }

    public function elements(): array
    {
        return $this->items();
    }

    public function toArray(): array
    {
        return array_map(function (CompanyUser $user) {
            return $user->toArray();
        }, $this->items());
    }

    protected function type(): string
    {
        return CompanyUser::class;
    }

}