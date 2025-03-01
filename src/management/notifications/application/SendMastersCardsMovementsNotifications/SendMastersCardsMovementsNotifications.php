<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendMastersCardsMovementsNotifications;


use Viabo\shared\domain\bus\command\Command;

final readonly class SendMastersCardsMovementsNotifications implements Command
{
    public function __construct(public array $cards)
    {
    }
}