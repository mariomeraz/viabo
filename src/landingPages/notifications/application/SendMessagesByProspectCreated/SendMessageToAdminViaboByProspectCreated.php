<?php declare(strict_types=1);

namespace Viabo\landingPages\notifications\application\SendMessagesByProspectCreated;

use Viabo\landingPages\prospect\domain\events\ProspectCreatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;

final readonly class SendMessageToAdminViaboByProspectCreated implements DomainEventSubscriber
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
        $data['correo'] = $data['email'];
        unset($data['email']);

        $email = new Email(
            ['pay@viabo.com', 'ramses@viabo.com'],
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Registro Nuevo - SET Pay - Banca Digital 24/7",
            'landing-pages/set/notifications/emails/notification.admin.set.html.twig',
            $data
        );

        $this->repository->send($email);
    }
}
