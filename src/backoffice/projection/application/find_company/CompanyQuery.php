<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company;


use Viabo\shared\domain\bus\query\Query;

final readonly class CompanyQuery implements Query
{
    public function __construct(public string $companyId)
    {
    }
}