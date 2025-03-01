<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateCardDemoCommand implements Command
{
    public function __construct(public string $cardId , public string $cvv , public string $expiration)
    {
    }
}