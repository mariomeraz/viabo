<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\find_user_by_card;


use Viabo\cardCloud\users\application\UserCardCloudResponse;
use Viabo\cardCloud\users\domain\UserCardCloudRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardCloudUserFinderByCard
{
    public function __construct(private UserCardCloudRepository $repository)
    {
    }

    public function __invoke(string $cardId): UserCardCloudResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'cardId.value', 'operator' => '=', 'value' => $cardId]
        ]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        return new UserCardCloudResponse($this->userData($users));
    }

    public function userData(array $users): array
    {
        if (empty($users)) {
            return ['ownerId' => '', 'name' => '', 'lastname' => '', 'email' => ''];
        }

        $user = $users[0]->toArray();
        unset(
            $user['id'],
            $user['businessId'],
            $user['cardId'],
            $user['createdByUser'],
            $user['createDate']
        );
        return $user;
    }
}