<?php declare(strict_types=1);


namespace Viabo\tickets\notifications\application\sendMessageByTicketClosed;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\tickets\ticket\domain\events\TicketClosedDomainEvent;

final readonly class SendMessageByTicketClosed implements DomainEventSubscriber
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public static function subscribedTo(): array
    {
        return [TicketClosedDomainEvent::class];
    }

    public function __invoke(TicketClosedDomainEvent $event): void
    {
        $ticket = $event->toPrimitives();
        $emails = $ticket['email'];

        if (empty($emails)) {
            return;
        }

        $email = new Email(
            $emails ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Notificación de Ticket #{$ticket['id']}" ,
            'tickets/notification/emails/message.ticket.closed.html.twig' ,
            [
                'ticket' => $ticket['id'] ,
                'createdDate' => $ticket['createDate'] ,
                'userName' => $ticket['applicantName'] . ' ' . $ticket['applicantLastName'] ,
                'description' => $ticket['description']
            ]
        );
        $this->repository->send($email);
    }
}