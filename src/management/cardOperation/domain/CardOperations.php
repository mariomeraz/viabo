<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\shared\domain\Collection;
use Viabo\shared\domain\Utils;

final class CardOperations extends Collection
{
    public function operations(): array
    {
        return $this->items();
    }

    public function remove(array $operationKey): static
    {
        $items = $this->items();
        foreach ($operationKey as $value) {
            unset($items[$value]);
        }

        return new static(Utils::removeDuplicateElements($items));
    }

    protected function type(): string
    {
        return CardOperation::class;
    }
}