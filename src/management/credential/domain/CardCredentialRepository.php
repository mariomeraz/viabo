<?php declare(strict_types=1);


namespace Viabo\management\credential\domain;


use Viabo\shared\domain\criteria\Criteria;

interface CardCredentialRepository
{
    public function save(CardCredential $credential): void;

    public function searchCriteria(Criteria $criteria): array;

    public function update(CardCredential $credential): void;

}