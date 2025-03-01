<?php

namespace Viabo\cardCloud\shared\infrastructure\doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Viabo\shared\infrastructure\doctrine\DoctrineEntityManagerFactory;

class CardCloudEntityManagerFactory
{
    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' !== $environment;

        $prefixes = array_merge(
            DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../cardCloud' , 'Viabo\cardCloud')
        );

        $dbalCustomTypesClasses = DbalTypesSearcher::inPath(__DIR__ . '/../../../../cardCloud' , 'cardCloud');

        return DoctrineEntityManagerFactory::create(
            $parameters,
            $prefixes,
            $isDevMode,
            $dbalCustomTypesClasses
        );
    }

}