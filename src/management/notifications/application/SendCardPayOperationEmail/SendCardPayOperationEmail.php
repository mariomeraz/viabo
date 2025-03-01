<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardPayOperationEmail;


use Viabo\management\cardOperation\domain\events\CardOperationCreatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;

final readonly class SendCardPayOperationEmail implements DomainEventSubscriber
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public static function subscribedTo(): array
    {
        return [CardOperationCreatedDomainEvent::class];
    }

    public function __invoke(CardOperationCreatedDomainEvent $event): void
    {
        $transactionData = $event->toPrimitives();
        $emails = $event->emails();

        if (!empty($transactionData['originCardMain']) || empty($emails)) {
            return;
        }

        $email = new Email(
            [$emails] ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            'Notificación de Transferencia' ,
            'management/notification/emails/card.pay.operation.html.twig' ,
            [
                'originCard' => substr($transactionData['originCard'] , -8) ,
                'destinationCard' => substr($transactionData['destinationCard'] , -8) ,
                'balance' => $transactionData['balance'] ,
                'registerDate' => $transactionData['registerDate'] ,
                'referencia' => $transactionData['payTransactionId']
            ]
        );
        $this->repository->send($email);
    }
}