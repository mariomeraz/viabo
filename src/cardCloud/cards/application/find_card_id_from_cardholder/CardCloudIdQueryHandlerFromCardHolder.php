<?php declare(strict_types=1);


namespace Viabo\cardCloud\cards\application\find_card_id_from_cardholder;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudIdQueryHandlerFromCardHolder implements QueryHandler
{
    public function __construct(private CardCloudCardIdFinder $finder)
    {
    }

    public function __invoke(CardCloudIdQueryFromCardHolder $query): Response
    {
        return $this->finder->__invoke($query->number, $query->nip, $query->date);
    }
}