<?php declare(strict_types=1);


namespace Viabo\management\card\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCardsOutsideCommand implements Command
{
    public function __construct(public string $cardRecorderId , public array $cardsInformation)
    {
    }
}