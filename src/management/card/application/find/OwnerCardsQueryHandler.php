<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class OwnerCardsQueryHandler implements QueryHandler
{
    public function __construct(private OwnerCardsFinder $finder)
    {
    }

    public function __invoke(OwnerCardsQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}