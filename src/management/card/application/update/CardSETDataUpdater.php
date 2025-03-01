<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\management\card\domain\CardPassword;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\CardUser;
use Viabo\management\card\domain\services\CardFinder;
use Viabo\management\shared\domain\card\CardClientKey;
use Viabo\management\shared\domain\card\CardId;
use Viabo\management\shared\domain\paymentProcessor\PaymentProcessorAdapter;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CardSETDataUpdater
{
    public function __construct(
        private CardRepository          $repository ,
        private CardFinder              $finder ,
        private PaymentProcessorAdapter $adapter ,
        private EventBus                $bus
    )
    {
    }

    public function __invoke(
        CardId        $cardId ,
        CardClientKey $clientKey ,
        CardUser      $user ,
        CardPassword  $password
    ): void
    {
        $card = $this->finder->__invoke($cardId);
        $card->registerCredentials($clientKey , $user , $password);
        $SETData = $this->adapter->searchCardInformation($card->credentials());
        $nip = $this->adapter->searchCardNip($card);
        $SETData['nip'] = $nip['TicketMessage'];

        $card->updateSETData($SETData);

        $this->repository->update($card);

        $this->bus->publish(...$card->pullDomainEvents());
    }
}