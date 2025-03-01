<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCardsMovementsCommandBySetApi implements Command
{
    public function __construct(
        public array  $cards ,
        public array  $cardsOperations ,
        public string $startDate ,
        public string $endDate ,
        public bool   $today
    )
    {
    }
}