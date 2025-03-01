<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\update_user_email_by_cardholder;


use Viabo\cardCloud\users\domain\events\UserCardCloudEmailUpdatedDomainEvent;
use Viabo\cardCloud\users\domain\exceptions\UserCardCloudNotExist;
use Viabo\cardCloud\users\domain\UserCardCloud;
use Viabo\cardCloud\users\domain\UserCardCloudRepository;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardCloudUserEmailUpdater
{
    public function __construct(private UserCardCloudRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(string $ownerId, string $email): void
    {
        $filters = Filters::fromValues([['field' => 'ownerId.value', 'operator' => '=', 'value' => $ownerId]]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($users)) {
            throw new UserCardCloudNotExist();
        }

        array_map(function (UserCardCloud $user) use ($email) {
            $user->updateEmail($email);
            $this->repository->update($user);
        }, $users);

        $data = ['userId' => $ownerId, 'email' => $email];
        $this->bus->publish(new UserCardCloudEmailUpdatedDomainEvent($ownerId, $data));
    }
}