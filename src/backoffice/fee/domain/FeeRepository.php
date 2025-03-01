<?php declare(strict_types=1);


namespace Viabo\backoffice\fee\domain;


interface FeeRepository
{
    public function searchAll(): array;
}