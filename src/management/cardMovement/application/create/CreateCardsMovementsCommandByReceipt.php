<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCardsMovementsCommandByReceipt implements Command
{
    public function __construct(public string $receiptId , public string $movements)
    {
    }
}