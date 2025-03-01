<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\update;


use Viabo\management\cardOperation\domain\events\CardOperationUpdateDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateTerminalTransactionLiquidationStatusByCardOperationReverse implements DomainEventSubscriber
{
    public function __construct(private TerminalTransactionLiquidationStatusUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CardOperationUpdateDomainEvent::class];
    }

    public function __invoke(CardOperationUpdateDomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $liquidationStatusId = '11';
        $this->updater->__invoke($data['referenceTerminal'], $liquidationStatusId);
    }
}