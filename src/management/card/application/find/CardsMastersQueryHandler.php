<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardsMastersQueryHandler implements QueryHandler
{
    public function __construct(private CardsMastersFinder $finder)
    {
    }

    public function __invoke(CardsMastersQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}