<?php declare(strict_types=1);


namespace Viabo\security\user\application\update_user_email_by_card_cloud;


use Viabo\cardCloud\users\domain\events\UserCardCloudEmailUpdatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateUserEmailByUserCardCloudUpdated implements DomainEventSubscriber
{
    public function __construct(private UserEmailUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [UserCardCloudEmailUpdatedDomainEvent::class];
    }

    public function __invoke(UserCardCloudEmailUpdatedDomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $this->updater->__invoke($data['userId'], $data['email']);
    }
}