<?php

namespace Viabo\shared\infrastructure\doctrine;

interface DoctrineCustomType
{
    public static function customTypeName(): string;
}