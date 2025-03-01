<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardReverseOperationEmail;


use Viabo\management\cardOperation\domain\events\CardOperationUpdateDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;

final readonly class SendCardReverseOperationEmail implements DomainEventSubscriber
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public static function subscribedTo(): array
    {
        return [CardOperationUpdateDomainEvent::class];
    }

    public function __invoke(CardOperationUpdateDomainEvent $event): void
    {
        $transactionData = $event->toPrimitives();
        $emails = $event->emails();

        if(empty($emails)){
            return;
        }

        $email = new Email(
            [$emails],
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            'Notificación de Transferencia',
            'management/notification/emails/card.reverse.operation.html.twig',
            [
                'originCard' => substr($transactionData['originCard'] , -8),
                'destinationCard' => substr($transactionData['destinationCard'] , -8),
                'balance' => $transactionData['balance'],
                'registerDate' => $transactionData['registerDate'],
                'referencia' => $transactionData['reverseTransactionId']
            ]
        );
        $this->repository->send($email);
    }
}