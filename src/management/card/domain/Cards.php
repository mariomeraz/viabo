<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\shared\domain\Collection;

final class Cards extends Collection
{
    public static function fromValues(array $values): static
    {
        return new static(array_map(self::cardViewBuilder() , $values));
    }

    private static function cardViewBuilder(): callable
    {
        return fn(array $values): CardView => CardView::fromValue($values);
    }

    public function cards(): array
    {
        return $this->items();
    }

    public function toArray(): array
    {
        return array_map(function (CardView $card) {
            return $card->toArray();
        } , $this->items());
    }

    protected function type(): string
    {
        return CardView::class;
    }
}