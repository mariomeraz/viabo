<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\find_service_by_card_cloud_subAccount;


use Viabo\shared\domain\bus\query\Query;

final readonly class ServiceCardCloudQueryBySubAccount implements Query
{
    public function __construct(public string $subAccountId)
    {
    }
}