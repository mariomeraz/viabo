<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\cards\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\cards\application\find_card_sensitive\CardCloudCardSensitiveQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCloudCardSensitiveFinderController extends ApiController
{

    public function __invoke(string $cardId, Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $cardSensitive = $this->ask(new CardCloudCardSensitiveQuery(
                $tokenData['businessId'],
                $cardId
            ));
            return new JsonResponse($cardSensitive->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}

