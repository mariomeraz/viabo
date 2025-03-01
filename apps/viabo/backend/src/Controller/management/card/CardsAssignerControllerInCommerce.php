<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\card;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\update\AssignCardsCommandInCommerce;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardsAssignerControllerInCommerce extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $this->dispatch(new AssignCardsCommandInCommerce(
                $data['commerceId'],
                $data['paymentProcessorId'],
                $data['amount']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}