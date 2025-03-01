<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\domain;


use Viabo\shared\domain\criteria\Criteria;

interface CredentialRepository
{
    public function save(Credential $credential): void;

    public function searchCriteria(Criteria $criteria): array;
}