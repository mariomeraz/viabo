<?php declare(strict_types=1);


namespace Viabo\backoffice\company\infrastructure\doctrine;


use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class CompanyIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return CompanyId::class;
    }
}