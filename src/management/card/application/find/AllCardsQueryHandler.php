<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class AllCardsQueryHandler implements QueryHandler
{
    public function __construct(private AllCardsFinder $finder)
    {
    }

    public function __invoke(AllCardsQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}