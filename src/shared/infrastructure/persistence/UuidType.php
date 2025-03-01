<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\persistence;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Viabo\shared\domain\Utils;
use Viabo\shared\infrastructure\doctrine\DoctrineCustomType;
use function Lambdish\Phunctional\last;

abstract class UuidType extends StringType implements DoctrineCustomType
{
    abstract protected function typeClassName(): string;

    public static function customTypeName(): string
    {
        return Utils::toSnakeCase(str_replace('Type' , '' , (string)last(explode('\\' , static::class))));
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    public function convertToPHPValue($value , AbstractPlatform $platform)
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    public function convertToDatabaseValue($value , AbstractPlatform $platform)
    {
        return $value;
    }
}