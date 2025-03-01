<?php declare(strict_types=1);


namespace Viabo\tickets\status\domain;


interface StatusRepository
{
    public function search(string $statusId): Status|null;
}