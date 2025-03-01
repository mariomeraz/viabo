<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardOwnerId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardQueryHandlerByOwner implements QueryHandler
{
    public function __construct(private CardFinderByOwner $finder)
    {
    }

    public function __invoke(CardQueryByOwner $query): Response
    {
        $ownerId = CardOwnerId::create($query->userId);

        return $this->finder->__invoke($ownerId);
    }
}