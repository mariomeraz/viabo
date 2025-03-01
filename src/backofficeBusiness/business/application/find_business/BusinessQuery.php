<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\application\find_business;


use Viabo\shared\domain\bus\query\Query;

final readonly class BusinessQuery implements Query
{
    public function __construct(public string $businessId)
    {
    }
}