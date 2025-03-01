<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\cards\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\cards\application\update_card_block_status\CardCloudCardBlockStatusUpdaterQuery;
use Viabo\cardCloud\users\application\find_user_by_card\CardCloudUserQuery;
use Viabo\cardCloud\users\application\find_users_by_business\CardCloudUsersQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCloudCardBlockController extends ApiController
{

    public function __invoke(string $cardId, string $blockStatus, Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $card = $this->ask(new CardCloudCardBlockStatusUpdaterQuery(
                $tokenData['businessId'],
                $cardId,
                $blockStatus
            ));
            $card = $this->addUserData($card->data);

            return new JsonResponse($card);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function addUserData(array $card): array
    {
        $user = $this->ask(new CardCloudUserQuery($card['card']['card_id']));
        $card['card'] = array_merge($card['card'], $user->data);
        return $card;
    }
}
