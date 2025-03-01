<?php declare(strict_types=1);


namespace Viabo\backoffice\shared\domain\commerce;


use Viabo\shared\domain\valueObjects\UuidValueObject;

final class CompanyLegalRepresentative extends UuidValueObject
{
    public static function empty(): static
    {
        $legalRepresentative = parent::random();
        $legalRepresentative->setEmpty();
        return $legalRepresentative;
    }

    private function setEmpty(): void
    {
        $this->value = '';
    }

    public function isNotEmpty(): bool
    {
        return !empty($this->value);
    }
}