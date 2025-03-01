<?php

namespace Viabo\landingPages\shared\infrastructure\doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Viabo\shared\infrastructure\doctrine\DoctrineEntityManagerFactory;

class LandingPagesEntityManagerFactory
{
    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' !== $environment;

        $prefixes = array_merge(
            DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../landingPages' , 'Viabo\landingPages')
        );

        $dbalCustomTypesClasses = DbalTypesSearcher::inPath(__DIR__ . '/../../../../landingPages' , 'landingPages');

        return DoctrineEntityManagerFactory::create(
            $parameters,
            $prefixes,
            $isDevMode,
            $dbalCustomTypesClasses
        );
    }

}