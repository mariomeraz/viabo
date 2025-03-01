<?php declare(strict_types=1);


namespace Viabo\security\user\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserProfile extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }

    public static function companyAdmin(): static
    {
        return new static('3');
    }

    public static function cardHolder(): static
    {
        $cardHolderProfileId = '4';
        return new static($cardHolderProfileId);
    }

    public function isLegalRepresentative(): bool
    {
        $legalRepresentativeProfileId = '3';
        return $this->value === $legalRepresentativeProfileId;
    }

    public function isNotOwnerCardCloud(): bool
    {
        return $this->value !== '8';
    }
}