<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendMastersCardsMovementsNotifications;


use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\utils\DatePHP;

final readonly class SendMastersCardsMovements
{
    public function __construct(private EmailRepository $repository , private DatePHP $date)
    {
    }

    public function __invoke(array $cards): void
    {
        $cards = $this->mergeCommerceMastersCards($cards);
        if (empty($cards)) {
            return;
        }

        array_map(function (array $card) {

            if (empty($card['ownerEmail']) || empty($card['cardsMovements'])) {
                return;
            }

            $todayDate = $this->date->now();
            $email = new Email(
                [$card['ownerEmail']] ,
                ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
                "Notificación de Viabo - Resumen de Movimientos de Cuentas Maestras - {$todayDate}" ,
                'management/notification/emails/summary.masters.cards.movements.today.html.twig' ,
                [
                    'ownerName' => $card['ownerName'] ,
                    'cardsMovements' => $card['cardsMovements'] ,
                    'date' => $todayDate
                ]
            );

            $this->repository->send($email);
        } , $cards);
    }

    private function mergeCommerceMastersCards(array $cards): array
    {
        $commerceMasterCards = [];
        foreach ($cards as $card) {
            $commerceId = $card['commerceId'];
            if (!array_key_exists($commerceId , $commerceMasterCards)) {
                $commerceMasterCards[$commerceId]['ownerName'] = $card['ownerName'];
                $commerceMasterCards[$commerceId]['ownerEmail'] = $card['ownerEmail'];
                $commerceMasterCards[$commerceId]['cardsMovements'] = [];
            }
            if (!empty($card['movements'])) {
                $commerceMasterCards[$commerceId]['cardsMovements'][] = [
                    'paymentProcessor' => $card['paymentProcessor'] ,
                    'cardNumber' => $card['number'] ,
                    'movements' => $card['movements']
                ];
            }
        }
        return $commerceMasterCards;
    }
}