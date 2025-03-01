<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\update_card_block_status;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudCardBlockStatusUpdaterQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudCardBlockStatusUpdater $updater)
    {
    }

    public function __invoke(CardCloudCardBlockStatusUpdaterQuery $query): Response
    {
        return $this->updater->__invoke($query->businessId, $query->cardId, $query->blockStatus);
    }
}
