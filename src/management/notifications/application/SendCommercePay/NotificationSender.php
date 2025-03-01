<?php declare(strict_types=1);

namespace Viabo\management\notifications\application\SendCommercePay;

use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\utils\URL;

final readonly class NotificationSender
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public function __invoke(array $terminalTransaction): void
    {
        $data = $terminalTransaction;
        $host = URL::get();
        $data['url'] = $host . "/cobro/" . $data['urlCode'];
        $data['privacityUrl'] = $host;

        $email = new Email(
            [$terminalTransaction['email']] ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Notificación de ViaboPay - Enlace de pago" ,
            'management/notification/emails/commerce.pay.notification.html.twig' ,
            [
                'fullName' => $data['fullName'] ,
                'url' => $data['url'] ,
                'amount' => $data['amount'] ,
                'description' => $data['description'] ,
                'privacityUrl' => $data['privacityUrl']
            ]
        );

        $this->repository->send($email);
    }
}
