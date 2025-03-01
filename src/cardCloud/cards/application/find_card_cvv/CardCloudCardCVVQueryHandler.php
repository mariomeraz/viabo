<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\find_card_cvv;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudCardCVVQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudCardCVVFinder $finder)
    {
    }

    public function __invoke(CardCloudCardCVVQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId, $query->cardId);
    }
}
