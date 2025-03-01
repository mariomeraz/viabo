<?php declare(strict_types=1);


namespace Viabo\tickets\notifications\application\sendMessageByTicketCreated;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\tickets\ticket\domain\events\TicketEmailsFoundDomainEvent;

final readonly class SendMessageByTicketCreated implements DomainEventSubscriber
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public static function subscribedTo(): array
    {
        return [TicketEmailsFoundDomainEvent::class];
    }

    public function __invoke(TicketEmailsFoundDomainEvent $event): void
    {
        $ticket = $event->toPrimitives();
        $emails = $ticket['emails'];

        if (empty($emails)) {
            return;
        }

        $email = new Email(
            $emails ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Notificación de Ticket #{$ticket['id']}" ,
            'tickets/notification/emails/message.ticket.created.html.twig' ,
            [
                'ticket' => $ticket['id'] ,
                'createdDate' => $ticket['createDate'] ,
                'userName' => $ticket['applicantName'] . ' ' . $ticket['applicantLastName'] ,
                'description' => $ticket['description'] ,
            ]
        );
        $this->repository->send($email);
    }
}