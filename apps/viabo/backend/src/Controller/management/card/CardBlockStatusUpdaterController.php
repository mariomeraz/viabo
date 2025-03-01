<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\card;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\update\UpdateCardBlockStatusCommand;
use Viabo\management\credential\application\find\CardCredentialQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardBlockStatusUpdaterController extends ApiController
{
    public function __invoke(string $cardId , string $blockStatus , Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $credential = $this->ask(new CardCredentialQuery($cardId));
            $this->dispatch(new UpdateCardBlockStatusCommand($cardId , $blockStatus , $credential->data));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}