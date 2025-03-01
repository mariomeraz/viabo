<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class FundingOrderQuery implements Query
{
    public function __construct(public string $fundingOrderId)
    {
    }
}