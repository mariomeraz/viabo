<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_card_cloud_owner_user;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudOwnerUserQuery implements Query
{
    public function __construct(public string $userId, public string $businessId)
    {
    }
}