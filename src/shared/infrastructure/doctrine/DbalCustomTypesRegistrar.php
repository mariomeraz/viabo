<?php

namespace Viabo\shared\infrastructure\doctrine;

use Doctrine\DBAL\Types\Type;
use function Lambdish\Phunctional\each;

class DbalCustomTypesRegistrar
{

    public static function register(array $dbalCustomTypesClasses): void
    {
        each(self::registerType() , $dbalCustomTypesClasses);
    }

    private static function registerType(): callable
    {
        return static function ($dbalCustomTypesClasses): void {
            if (!Type::hasType($dbalCustomTypesClasses::customTypeName())) {
                Type::addType($dbalCustomTypesClasses::customTypeName() , $dbalCustomTypesClasses);
            }
        };
    }

}