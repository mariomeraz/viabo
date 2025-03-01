<?php declare(strict_types=1);


namespace Viabo\security\notification\application\SendResetPasswordEmailByAssignedCardDemo;


use Viabo\security\user\domain\events\SendUserPasswordDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\service\find_business\BusinessFinder;

final readonly class SendResetPasswordEmailByAssignedCardDemo implements DomainEventSubscriber
{
    public function __construct(
        private EmailRepository $repository,
        private BusinessFinder  $businessFinder
    )
    {
    }

    public static function subscribedTo(): array
    {
        return [SendUserPasswordDomainEvent::class];
    }

    public function __invoke(SendUserPasswordDomainEvent $event): void
    {
        $userData = $event->toPrimitives();
        $password = $event->password();
        $business = $this->businessFinder->__invoke($userData['businessId']);
        $host = $business['host'];

        $userEmail = $userData['email'];
        $email = new Email(
            [$userEmail],
            ['email' => "noreply@set.lat", 'name' => 'Notificaciones'],
            'Notificación de Acceso',
            "security/{$business['templateFile']}/notification/emails/user.created.by.assigned.card.html.twig",
            [
                'name' => $userData['name'],
                'password' => $password,
                'userEmail' => $userEmail,
                'host' => "$host/auth/login"
            ]
        );
        $this->repository->send($email);
    }
}