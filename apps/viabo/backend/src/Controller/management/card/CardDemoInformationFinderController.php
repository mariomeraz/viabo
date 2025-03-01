<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\card;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\find\CardDemoQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardDemoInformationFinderController extends ApiController
{
    public function __invoke(string $cardNumber , Request $request): Response
    {
        try {
            $data = $this->ask(new CardDemoQuery($cardNumber));
            $token = $this->encode($data->data);

            return new JsonResponse(['token' => $token]);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}