<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\management\shared\domain\card\CardId;

final class CardMovementLog
{
    public function __construct(
        private CardMovementLogId    $id ,
        private CardId               $cardId ,
        private CardMovementLogError $error ,
        private CardMovementLogDate  $date
    )
    {
    }

    public static function create(string $cardId , string $error): static
    {
        return new static(
            CardMovementLogId::random() ,
            CardId::create($cardId) ,
            new CardMovementLogError($error) ,
            CardMovementLogDate::todayDate()
        );
    }

}