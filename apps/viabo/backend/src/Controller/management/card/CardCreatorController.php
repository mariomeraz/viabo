<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\card;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\create\CreateCardCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $this->opensslDecrypt($request->toArray());
            $this->dispatch(new CreateCardCommand(
                $tokenData['id'] ,
                $data['cardNumber'] ,
                $data['expirationDate'] ,
                $data['cvv'] ,
                $data['paymentProcessorId'] ,
                $data['commerceId']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}