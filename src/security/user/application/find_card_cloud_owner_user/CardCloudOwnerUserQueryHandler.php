<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_card_cloud_owner_user;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudOwnerUserQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudOwnerUserFinder $finder)
    {
    }

    public function __invoke(CardCloudOwnerUserQuery $query): Response
    {
        return $this->finder->__invoke($query->userId, $query->businessId);
    }
}