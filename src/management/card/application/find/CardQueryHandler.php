<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardQueryHandler implements QueryHandler
{
    public function __construct(private CardFinder $finder)
    {
    }

    public function __invoke(CardQuery $query): Response
    {
        return $this->finder->__invoke($query->cardId);
    }
}