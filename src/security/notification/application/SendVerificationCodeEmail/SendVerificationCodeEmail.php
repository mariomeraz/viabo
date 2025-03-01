<?php declare(strict_types=1);


namespace Viabo\security\notification\application\SendVerificationCodeEmail;


use Viabo\security\code\domain\events\CodeCreatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\service\find_business\BusinessFinder;

final readonly class SendVerificationCodeEmail implements DomainEventSubscriber
{
    public function __construct(
        private EmailRepository $repository,
        private BusinessFinder  $businessFinder
    )
    {
    }

    public static function subscribedTo(): array
    {
        return [CodeCreatedDomainEvent::class];
    }

    public function __invoke(CodeCreatedDomainEvent $event): void
    {
        $userData = $event->toPrimitives();
        $business = $this->businessFinder->__invoke($userData['businessId']);

        $email = new Email(
            [$userData['email']],
            ['email' => "noreply@set.lat", 'name' => 'Notificaciones'],
            'Verificiación de Identidad',
            "security/{$business['templateFile']}/notification/emails/verification.code.html.twig",
            [
                'name' => "{$userData['name']} {$userData['lastname']}",
                'code' => $userData['code']
            ]
        );
        $this->repository->send($email);
    }
}