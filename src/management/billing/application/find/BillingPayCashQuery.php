<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class BillingPayCashQuery implements Query
{
    public function __construct(public string $referencePayCash)
    {
    }
}