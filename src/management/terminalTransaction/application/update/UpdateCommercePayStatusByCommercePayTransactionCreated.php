<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\update;

use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\management\terminalTransaction\domain\CommercePayApiAuthCode;
use Viabo\management\terminalTransaction\domain\CommercePayApiReferenceNumber;
use Viabo\management\terminalTransaction\domain\CommercePayStatusId;
use Viabo\management\terminalTransactionLog\domain\events\CommercePayTransactionCreatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateCommercePayStatusByCommercePayTransactionCreated implements DomainEventSubscriber
{
    public function __construct(private CommercePayUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CommercePayTransactionCreatedDomainEvent::class];
    }

    public function __invoke(CommercePayTransactionCreatedDomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $id = new CommercePayId($data['commercePayId']);
        $statusId = new CommercePayStatusId($data['statusId']);

        $authCode = new CommercePayApiAuthCode($data['apiData']['auth_code']??'');
        $referenceNumber = new CommercePayApiReferenceNumber($data['apiData']['reference_number']??'');

        $this->updater->__invoke($id , $statusId,$authCode,$referenceNumber);
    }
}
