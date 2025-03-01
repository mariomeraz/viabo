<?php declare(strict_types=1);


namespace Viabo\tickets\notifications\application\sendMessageByMessageCreated;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\tickets\message\domain\events\MessageAdditionalDataFoundDomainEvent;

final readonly class sendMessageByMessageCreated implements DomainEventSubscriber
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public static function subscribedTo(): array
    {
        return [MessageAdditionalDataFoundDomainEvent::class];
    }

    public function __invoke(MessageAdditionalDataFoundDomainEvent $event): void
    {
        $message = $event->toPrimitives();
        $emails = $message['emails'];

        if (empty($emails)) {
            return;
        }

        $email = new Email(
            $emails ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Notificación de Ticket #{$message['ticketId']}" ,
            'tickets/notification/emails/new.message.created.html.twig' ,
            [
                'ticket' => $message['ticketId'] ,
                'createdDate' => $message['createDate'] ,
                'userName' => $message['userName'] ,
                'description' => $message['description']
            ]
        );
        $this->repository->send($email);
    }
}