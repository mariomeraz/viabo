<?php declare(strict_types=1);

namespace Viabo\cardCloud\transactions\application\create_card_transfer;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudCardTransferCreatorQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudCardTransferCreator $creator)
    {
    }

    public function __invoke(CardCloudCardTransferCreatorQuery $query): Response
    {
        return $this->creator->__invoke(
            $query->businessId,
            $query->sourceType,
            $query->source,
            $query->destinationType,
            $query->destination,
            $query->amount,
            $query->description
        );
    }
}
