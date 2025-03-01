<?php declare(strict_types=1);


namespace Viabo\backoffice\logs\domain;


interface LogRepository
{
    public function save(Log $log): void;
}