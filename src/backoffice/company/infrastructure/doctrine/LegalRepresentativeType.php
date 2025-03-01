<?php declare(strict_types=1);


namespace Viabo\backoffice\company\infrastructure\doctrine;


use Viabo\backoffice\shared\domain\commerce\CompanyLegalRepresentative;
use Viabo\shared\infrastructure\persistence\UuidType;

final class LegalRepresentativeType extends UuidType
{
    protected function typeClassName(): string
    {
        return CompanyLegalRepresentative::class;
    }
}