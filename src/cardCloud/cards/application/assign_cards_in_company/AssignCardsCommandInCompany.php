<?php declare(strict_types=1);


namespace Viabo\cardCloud\cards\application\assign_cards_in_company;


use Viabo\shared\domain\bus\command\Command;

final readonly class AssignCardsCommandInCompany implements Command
{
    public function __construct(public string $businessId, public array $data)
    {
    }
}