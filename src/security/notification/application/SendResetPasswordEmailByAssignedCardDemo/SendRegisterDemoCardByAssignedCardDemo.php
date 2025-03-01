<?php declare(strict_types=1);


namespace Viabo\security\notification\application\SendResetPasswordEmailByAssignedCardDemo;


use Viabo\security\user\domain\events\SendUserPasswordDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\service\find_business\BusinessFinder;

final readonly class SendRegisterDemoCardByAssignedCardDemo implements DomainEventSubscriber
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
        $user = $event->toPrimitives();
        $business = $this->businessFinder->__invoke($user['businessId']);
        $legalRepresentative = $event->legaRepresentative();
        $cardNumber = $event->cardNumber();

        $email = new Email(
            [$legalRepresentative['email']],
            ['email' => "noreply@set.lat", 'name' => 'Notificaciones'],
            'Notificación - Registro de tarjeta Demo',
            "security/{$business['templateFile']}/notification/emails/registered.user.by.demo.card.html.twig",
            [
                'legalRepresentativeName' => $legalRepresentative['name'],
                'userName' => $user['name'],
                'userEmail' => $user['email'],
                'cardNumber' => $cardNumber
            ]
        );
        $this->repository->send($email);
    }
}