<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\cards\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\cards\application\find_card_id_from_cardholder\CardCloudIdQueryFromCardHolder;
use Viabo\cardCloud\users\application\find_user_by_card\CardCloudUserQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCloudIdFinderFromCardHolderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $data['ciphertext'] = $request->query->get('ciphertext');
            $data['iv'] = $request->query->get('iv');
            $data = $this->opensslDecrypt($data);
            $cardId = $this->ask(new CardCloudIdQueryFromCardHolder(
                $data['number'],
                $data['nip'],
                $data['date']
            ));
            $this->ensureCardNotUsed($cardId->data);

            return new JsonResponse($cardId->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    private function ensureCardNotUsed(array $card): void
    {
        $user = $this->ask(new CardCloudUserQuery($card['card_id']));
        if (!empty($user->data['ownerId'] && !empty($user->data['email']))) {
            throw new \DomainException('Ya esta asignada la tarjeta', 400);
        }

    }
}
