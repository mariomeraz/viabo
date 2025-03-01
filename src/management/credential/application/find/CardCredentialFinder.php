<?php declare(strict_types=1);


namespace Viabo\management\credential\application\find;


use Viabo\management\credential\domain\services\CardCredentialFinder as CardCredentialFinderService;
use Viabo\management\shared\domain\card\CardId;

final readonly class CardCredentialFinder
{
    public function __construct(private CardCredentialFinderService $finder)
    {
    }

    public function __invoke(CardId $cardId): CardCredentialResponse
    {
        $credential = $this->finder->__invoke($cardId);
        return new CardCredentialResponse($credential->toArray());

    }

}