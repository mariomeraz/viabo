<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\management\card\domain\events\CardCVVUpdatedDomainEvent;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateCardNipByDemoCardUpdated implements DomainEventSubscriber
{
    public function __construct(private CardNipUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CardCVVUpdatedDomainEvent::class];
    }

    public function __invoke(CardCVVUpdatedDomainEvent $event): void
    {
        $cardId = CardId::create($event->aggregateId());

        $this->updater->__invoke($cardId);
    }
}