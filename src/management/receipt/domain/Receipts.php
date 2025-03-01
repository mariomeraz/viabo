<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain;


use Viabo\shared\domain\Collection;

final class Receipts extends Collection
{
    public function getItems(): array
    {
        return $this->items();
    }
    protected function type(): string
    {
        return Receipt::class;
    }
}