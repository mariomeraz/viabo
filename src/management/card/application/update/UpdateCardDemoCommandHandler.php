<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\management\card\domain\CardCVV;
use Viabo\management\card\domain\CardExpirationDate;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCardDemoCommandHandler implements CommandHandler
{
    public function __construct(private CardDemoUpdater $updater)
    {
    }

    public function __invoke(UpdateCardDemoCommand $command): void
    {
        $cardId = CardId::create($command->cardId);
        $cvv = CardCVV::create($command->cvv);
        $expiration = CardExpirationDate::create($command->expiration);

        $this->updater->__invoke($cardId , $cvv , $expiration);
    }
}
