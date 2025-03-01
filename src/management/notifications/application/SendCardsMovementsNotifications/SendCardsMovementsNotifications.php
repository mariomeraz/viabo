<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardsMovementsNotifications;


use Viabo\shared\domain\bus\command\Command;

final readonly class SendCardsMovementsNotifications implements Command
{
    public function __construct(public array $cards)
    {
    }
}