<?php

namespace Viabo\shared\infrastructure\doctrine;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\ORMSetup;

class DoctrineEntityManagerFactory
{
    private static $sharedPrefixes = [
        __DIR__ . '/../../../shared/infrastructure/persistence/mappings' => 'Viabo\shared\domain' ,
    ];

    public static function create(
        array $parameters ,
        array $contextPrefixes ,
        bool  $isDevMode ,
        array $dbalCustomTypesClasses
    ): EntityManagerInterface
    {

        DbalCustomTypesRegistrar::register($dbalCustomTypesClasses);

        return EntityManager::create($parameters , self::createConfiguration($contextPrefixes , $isDevMode));
    }

    private static function createConfiguration(array $contextPrefixes , bool $isDevMode): Configuration
    {
        $config = ORMSetup::createConfiguration($isDevMode);

        $config->setMetadataDriverImpl(new SimplifiedXmlDriver(array_merge(self::$sharedPrefixes , $contextPrefixes)));

        return $config;
    }

}