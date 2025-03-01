<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\transactions\create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\transactions\application\create_card_transfer\CardCloudCardTransferCreatorQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCloudTransferCreatorController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $cardSensitive = $this->ask(new CardCloudCardTransferCreatorQuery(
                $tokenData['businessId'],
                $data['sourceType'],
                $data['source'],
                $data['destinationType'],
                $data['destination'],
                $data['amount'],
                $data['description']
            ));
            return new JsonResponse($cardSensitive->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
