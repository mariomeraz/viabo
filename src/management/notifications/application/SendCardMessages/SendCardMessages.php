<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardMessages;


use Viabo\management\notifications\domain\exceptions\NotificationEmailEmpty;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;

final readonly class SendCardMessages
{
    public function __construct(private EmailRepository $repository)
    {
    }

    public function __invoke(string $subject , array $emails , string $message): void
    {
        if (empty($emails)) {
            throw new NotificationEmailEmpty();
        }

        $email = new Email(
            $emails ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Notificación de Viabo - $subject" ,
            'management/notification/emails/cards.message.html.twig' ,
            ['subject' => $subject , 'message' => $message]
        );
        $this->repository->send($email);
    }

}