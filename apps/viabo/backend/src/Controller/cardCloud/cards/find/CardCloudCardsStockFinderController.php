<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\cards\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\cards\application\find_cards_stock\CardCloudCardsStockQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCloudCardsStockFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $cardDetails = $this->ask(new CardCloudCardsStockQuery($tokenData['businessId']));

            return new JsonResponse($cardDetails->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
