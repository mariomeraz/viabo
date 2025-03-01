<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_subaccount_card_cloud_by_company;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudSubAccountQueryByCompany implements Query
{
    public function __construct(public string $companyId)
    {
    }
}