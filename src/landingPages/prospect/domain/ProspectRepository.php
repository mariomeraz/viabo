<?php declare(strict_types=1);


namespace Viabo\landingPages\prospect\domain;


interface ProspectRepository
{
    public function save(Prospect $prospect): void;

    public function searchEmail(string $email): Prospect|null;
}