<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class DepositReferenceQuery implements Query
{
    public function __construct(public mixed $apiKey)
    {
    }
}