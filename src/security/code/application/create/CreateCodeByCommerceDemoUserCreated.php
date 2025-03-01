<?php declare(strict_types=1);


namespace Viabo\security\code\application\create;


use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\events\CommerceDemoUserCreatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateCodeByCommerceDemoUserCreated implements DomainEventSubscriber
{
    public function __construct(private CodeCreator $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [CommerceDemoUserCreatedDomainEvent::class];
    }

    public function __invoke(CommerceDemoUserCreatedDomainEvent $event): void
    {
        $userId = new UserId($event->aggregateId());
        $userData = $event->toPrimitives();
        //var_dump($userData);
        //var_dump($userId);

        $user = array_merge(
            ['id' => (string) $userId], // Convertir UserId a string
            $userData
        );
        ($this->creator)($user);
        //($this->creator)($userId , $userData);
    }
}