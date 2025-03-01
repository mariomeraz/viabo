<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class CostCentersQuery implements Query
{
    public function __construct(public string $businessId)
    {
    }
}