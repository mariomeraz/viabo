<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\management\card\domain\CardPassword;
use Viabo\management\card\domain\CardUser;
use Viabo\management\shared\domain\card\CardClientKey;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCardSETDataCommandHandler implements CommandHandler
{
    public function __construct(private CardSETDataUpdater $updater)
    {
    }

    public function __invoke(UpdateCardSETDataCommand $command): void
    {
        $cardId = CardId::create($command->cardId);
        $clientKey = CardClientKey::create($command->cardCredential['clientKey']);
        $user = CardUser::create($command->cardCredential['userName']);
        $password = CardPassword::create($command->cardCredential['password']);
        $this->updater->__invoke($cardId , $clientKey , $user , $password);
    }
}