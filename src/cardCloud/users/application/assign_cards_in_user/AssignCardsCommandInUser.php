<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\assign_cards_in_user;


use Viabo\shared\domain\bus\command\Command;

final readonly class AssignCardsCommandInUser implements Command
{
    public function __construct(public string $businessId, public string $userId, public array $data)
    {
    }
}