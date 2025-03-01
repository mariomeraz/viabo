<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\find_card_sensitive;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudCardSensitiveQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudCardSensitiveFinder $finder)
    {
    }

    public function __invoke(CardCloudCardSensitiveQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId, $query->cardId);
    }
}
