<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class BalanceInTransactionQuery implements Query
{
    public function __construct(public array $cardsNumber)
    {
    }
}