<?php declare(strict_types=1);


namespace Viabo\cardCloud\cards\application\find_cards_stock;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudCardsStockQuery implements Query
{
    public function __construct(public string $businessId)
    {
    }
}