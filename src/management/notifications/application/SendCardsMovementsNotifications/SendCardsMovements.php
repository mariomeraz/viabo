<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardsMovementsNotifications;


use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\utils\DatePHP;

final readonly class SendCardsMovements
{
    public function __construct(private EmailRepository $repository , private DatePHP $date)
    {
    }

    public function __invoke(
        string $ownerName ,
        string $ownerEmail ,
        string $cardNumber ,
        array  $movements
    ): void
    {
        if (empty($ownerEmail) || empty($movements)) {
            return;
        }

        $todayDate = $this->date->now();
        $email = new Email(
            [$ownerEmail] ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Notificación de Viabo - Resumen de Movimientos de Tarjeta - {$todayDate}" ,
            'management/notification/emails/summary.card.movements.today.html.twig' ,
            [
                'ownerName' => $ownerName ,
                'cardNumber' => $cardNumber ,
                'movements' => $movements ,
                'date' => $todayDate
            ]
        );

        $this->repository->send($email);
    }
}