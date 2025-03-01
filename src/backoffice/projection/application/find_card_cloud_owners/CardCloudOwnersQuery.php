<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_card_cloud_owners;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudOwnersQuery implements Query
{
    public function __construct(public string $companyId)
    {
    }
}