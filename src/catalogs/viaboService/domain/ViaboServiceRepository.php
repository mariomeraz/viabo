<?php declare(strict_types=1);


namespace Viabo\catalogs\viaboService\domain;


interface ViaboServiceRepository
{
    public function searchAll(): array;
}