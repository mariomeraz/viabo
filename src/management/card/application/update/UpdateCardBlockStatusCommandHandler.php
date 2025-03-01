<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\management\card\domain\CardBlock;
use Viabo\management\card\domain\CardPassword;
use Viabo\management\card\domain\CardUser;
use Viabo\management\shared\domain\card\CardClientKey;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCardBlockStatusCommandHandler implements CommandHandler
{
    public function __construct(private CardBlockStatusUpdater $updater)
    {
    }

    public function __invoke(UpdateCardBlockStatusCommand $command): void
    {
        $cardId = new CardId($command->cardId);
        $cardStatus = CardBlock::create($command->blockStatus);
        $clientKey = CardClientKey::create($command->credentialData['clientKey']);
        $user = CardUser::create($command->credentialData['userName']);
        $password = CardPassword::create($command->credentialData['password']);

        ($this->updater)($cardId , $cardStatus , $clientKey , $user , $password);
    }
}