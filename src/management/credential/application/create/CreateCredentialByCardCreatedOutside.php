<?php declare(strict_types=1);


namespace Viabo\management\credential\application\create;


use Viabo\management\card\domain\events\CardCreatedOutsideDomainEvent;
use Viabo\management\credential\domain\CardCredentialEmail;
use Viabo\management\credential\domain\CardCredentialPassword;
use Viabo\management\credential\domain\CardCredentialUserName;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateCredentialByCardCreatedOutside implements DomainEventSubscriber
{
    public function __construct(private CredentialCreatorOutside $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [CardCreatedOutsideDomainEvent::class];
    }

    public function __invoke(CardCreatedOutsideDomainEvent $event): void
    {
        $cardId = new CardId($event->aggregateId());
        $userData = $event->toPrimitives();
        $userEmail = CardCredentialEmail::create($userData['userEmail']);
        $userName = CardCredentialUserName::create($userData['userName']);
        $userPassword = CardCredentialPassword::create($userData['userPassword']);

        $this->creator->__invoke($cardId , $userEmail , $userName , $userPassword);
    }
}