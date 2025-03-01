<?php declare(strict_types=1);


namespace Viabo\management\credential\application\find;


use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FindCardCredentialQueryHandler implements QueryHandler
{
    public function __construct(private CardCredentialFinder $finder)
    {
    }

    public function __invoke(CardCredentialQuery $query): Response
    {
        $cardId = CardId::create($query->cardId);
        return $this->finder->__invoke($cardId);
    }
}