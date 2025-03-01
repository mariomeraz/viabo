<?php declare(strict_types=1);


namespace Viabo\management\credential\application\find;


use Viabo\backoffice\credential\application\find\CredentialResponse;
use Viabo\management\credential\domain\services\CardCredentialFinder;
use Viabo\management\shared\domain\card\CardId;

final readonly class CardsCredentialsFinder
{

    public function __construct(private CardCredentialFinder $finder)
    {
    }

    public function __invoke(array $cards): CredentialResponse
    {
        return new CredentialResponse(array_map(function (array $card) {
            $cardId = new CardId($card['id']);
            $credential = $this->finder->__invoke($cardId);
            $card['clientKey'] = $credential->clientKey()->value();
            return $card;
        } , $cards));
    }
}