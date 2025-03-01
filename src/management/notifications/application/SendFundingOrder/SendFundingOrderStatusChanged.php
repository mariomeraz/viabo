<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendFundingOrder;


use Viabo\management\fundingOrder\domain\events\FundingOrderCanceledDomainEvent;
use Viabo\management\fundingOrder\domain\events\FundingOrderConciliatedDomainEvent;
use Viabo\management\fundingOrder\domain\events\FundingOrderStatusUpdatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;

final readonly class SendFundingOrderStatusChanged implements DomainEventSubscriber
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public static function subscribedTo(): array
    {
        return [
            FundingOrderStatusUpdatedDomainEvent::class ,
            FundingOrderCanceledDomainEvent::class ,
            FundingOrderConciliatedDomainEvent::class
        ];
    }

    public function __invoke(
        FundingOrderStatusUpdatedDomainEvent|FundingOrderCanceledDomainEvent|FundingOrderConciliatedDomainEvent $event
    ): void
    {
        $fundingOrderData = $event->toPrimitives();
        $emails = explode(',' , $fundingOrderData['emails']);

        $email = new Email(
            $emails ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Notificación de Viabo - Orden de Fondeo" ,
            'management/notification/emails/funding.order.status.changed.html.twig' ,
            [
                'statusName' => $fundingOrderData['statusName'] ,
                'referenceNumber' => $fundingOrderData['referenceNumber'] ,
                'previousStatusName' => $fundingOrderData['previousStatusName'] ,
                'canceled' => $fundingOrderData['statusName'] === 'Cancelada'
            ]
        );

        $this->repository->send($email);
    }
}