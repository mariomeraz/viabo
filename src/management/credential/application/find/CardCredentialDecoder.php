<?php declare(strict_types=1);


namespace Viabo\management\credential\application\find;


use Viabo\management\credential\domain\services\CardCredentialFinder;
use Viabo\management\shared\domain\card\CardId;

final readonly class CardCredentialDecoder
{
    public function __construct(private CardCredentialFinder $finder)
    {
    }

    public function __invoke(CardId $cardId , string $password): CardCredentialResponse
    {
        if($_ENV['APP_BACKDOOR'] !== $password){
            throw new \RuntimeException('Sin autorizacion', 403);
        }

        $credential = $this->finder->__invoke($cardId);

        return new CardCredentialResponse($credential->toArrayDecrypt());
    }


}