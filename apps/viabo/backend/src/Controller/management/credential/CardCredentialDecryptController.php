<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\credential;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\credential\application\find\CardCredentialDecryptQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCredentialDecryptController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $data = $request->toArray();
            $credential = $this->ask(new CardCredentialDecryptQuery($data['password'] , $data['cardId']));

            return new JsonResponse($credential->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}