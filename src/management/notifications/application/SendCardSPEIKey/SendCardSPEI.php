<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardSPEIKey;


use Viabo\management\notifications\domain\exceptions\NotificationDataEmpty;
use Viabo\management\notifications\domain\exceptions\NotificationEmailEmpty;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;

final readonly class SendCardSPEI
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public function __invoke(string $spei , array $emails): void
    {
        if (empty($emails)) {
            throw new NotificationEmailEmpty();
        }

        if (empty($spei)) {
            throw new NotificationDataEmpty();
        }

        $email = new Email(
            $emails ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Notificación - SPEI" ,
            'management/notification/emails/card.spei.key.html.twig' ,
            ['spei' => $spei ]
        );

        $this->repository->send($email);
    }
}