<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_card_cloud_owners;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudOwnersQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudOwnersFinder $finder)
    {
    }

    public function __invoke(CardCloudOwnersQuery $query): Response
    {
        return $this->finder->__invoke($query->companyId);
    }

}