<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\management\card\domain\CardBlock;
use Viabo\management\card\domain\CardPassword;
use Viabo\management\card\domain\CardUser;
use Viabo\management\card\domain\services\CardFinder;
use Viabo\management\shared\domain\card\CardClientKey;
use Viabo\management\shared\domain\card\CardId;
use Viabo\management\shared\domain\paymentProcessor\PaymentProcessorAdapter;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CardBlockStatusUpdater
{
    public function __construct(
        private CardFinder              $finder ,
        private PaymentProcessorAdapter $adapter ,
        private EventBus                $bus
    )
    {
    }

    public function __invoke(
        CardId        $cardId ,
        CardBlock     $blockStatus ,
        CardClientKey $clientKey ,
        CardUser      $user ,
        CardPassword  $password
    ): void
    {
        $card = $this->finder->__invoke($cardId);
        $card->registerCredentials($clientKey , $user , $password);
        $card->updateBlock($blockStatus);

        $this->adapter->updateBlock($card);

        $this->bus->publish(...$card->pullDomainEvents());
    }
}