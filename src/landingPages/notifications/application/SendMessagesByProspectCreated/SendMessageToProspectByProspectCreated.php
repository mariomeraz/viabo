<?php declare(strict_types=1);

namespace Viabo\landingPages\notifications\application\SendMessagesByProspectCreated;

use Viabo\landingPages\prospect\domain\events\ProspectCreatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;

final readonly class SendMessageToProspectByProspectCreated implements DomainEventSubscriber
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public static function subscribedTo(): array
    {
        return [ProspectCreatedDomainEvent::class];
    }

    public function __invoke(ProspectCreatedDomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $emails = $data['email'];

        $email = new Email(
            [$emails] ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "SET Pay - Banca Digital 24/7" ,
            'landing-pages/set/notifications/emails/notification.prospect.set.html.twig' ,
            []
        );

        $this->repository->send($email);
    }
}
