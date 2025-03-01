<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class AssignCardCommandHandlerInCommerce implements CommandHandler
{
    public function __construct(private CardAssignerInCommerce $assigner)
    {
    }

    public function __invoke(AssignCardCommandInCommerce $command): void
    {
        $cardId = new CardId($command->cardId);
        $commerceId = new CardCommerceId($command->commerceId);

        ($this->assigner)($cardId , $commerceId);
    }
}