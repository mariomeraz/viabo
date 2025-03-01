<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\cards\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\cards\application\find_sub_account_cards\CardCloudSubAccountCardsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\cardCloud\users\application\find_users_by_business\CardCloudUsersQuery;

final readonly class CardCloudSubAccountCardsFinderController extends ApiController
{

    public function __invoke(string $subAccountId, Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $users = $this->ask(new CardCloudUsersQuery($tokenData['businessId']));
            $cardCloudCards = $this->ask(new CardCloudSubAccountCardsQuery(
                $tokenData['businessId'],
                $subAccountId,
                $users->data
            ));
            return new JsonResponse($cardCloudCards->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
