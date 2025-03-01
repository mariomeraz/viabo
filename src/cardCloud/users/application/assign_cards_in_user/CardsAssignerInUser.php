<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\assign_cards_in_user;


use Viabo\security\user\application\find_card_cloud_owner_user\CardCloudOwnerUserQuery;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\cardCloud\users\domain\exceptions\UserCardCloudExist;
use Viabo\cardCloud\users\domain\UserCardCloud;
use Viabo\cardCloud\users\domain\UserCardCloudRepository;

final readonly class CardsAssignerInUser
{
    public function __construct(
        private UserCardCloudRepository $repository,
        private QueryBus                $queryBus
    )
    {
    }

    public function __invoke(
        string $businessId,
        string $userId,
        array  $cards,
        string $owner
    ): void
    {
        $this->ensureCards($cards);
        $owner = $this->searchOwner($businessId, $owner);

        foreach ($cards as $card) {
            $user = UserCardCloud::create(
                $businessId,
                $card,
                $owner['id'],
                $owner['name'],
                $owner['lastname'],
                $owner['email'],
                $userId
            );
            $this->repository->save($user);
        }
    }

    private function ensureCards(array $cards): void
    {
        $filters = Filters::fromValues([
            ['field' => 'cardId.value', 'operator' => 'IN', 'value' => implode(',', $cards)]
        ]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        if (!empty($users)) {
            throw new UserCardCloudExist();
        }
    }

    private function searchOwner(string $businessId, string $userId): array
    {
        $user = $this->queryBus->ask(new CardCloudOwnerUserQuery($userId, $businessId));
        return $user->data;
    }
}