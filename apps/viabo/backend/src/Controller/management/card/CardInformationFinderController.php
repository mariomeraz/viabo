<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\card;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\find\CardInformationQuery;
use Viabo\management\credential\application\find\CardCredentialQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardInformationFinderController extends ApiController
{
    public function __invoke(string $cardId , Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $credential = $this->ask(new CardCredentialQuery($cardId));
            $card = $this->ask(new CardInformationQuery($cardId , $credential->data));

            return new JsonResponse($this->opensslEncrypt($card->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}