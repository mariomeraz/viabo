<?php declare(strict_types=1);


namespace Viabo\shared\domain\utils;


abstract class Collection
{
    public function __construct(protected $collection = [])
    {
    }

    public function add(object $data): void
    {
        $this->collection[] = $data;
    }

    public function getCollection(): array
    {
        return $this->collection;
    }

}