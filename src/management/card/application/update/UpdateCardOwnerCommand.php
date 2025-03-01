<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateCardOwnerCommand implements Command
{
    public function __construct(public array $cards , public string $userId)
    {
    }
}