<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\management\card\domain\CardPassword;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\CardUser;
use Viabo\management\card\domain\services\CardFinder;
use Viabo\management\credential\application\find\CardCredentialQuery;
use Viabo\management\shared\domain\card\CardClientKey;
use Viabo\management\shared\domain\card\CardId;
use Viabo\management\shared\domain\paymentProcessor\PaymentProcessorAdapter;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class CardNipUpdater
{
    public function __construct(
        private CardRepository          $repository ,
        private CardFinder              $finder ,
        private PaymentProcessorAdapter $adapter ,
        private QueryBus                $queryBus ,
        private EventBus                $bus
    )
    {
    }

    public function __invoke(CardId $cardId): void
    {
        $card = $this->finder->__invoke($cardId);

        $credential = $this->searchCredential($cardId);
        $clientKey = new CardClientKey($credential['clientKey']);
        $user = new  CardUser($credential['userName']);
        $password = new  CardPassword($credential['password']);
        $card->registerCredentials($clientKey , $user , $password);

        $nip = $this->adapter->searchCardNip($card);
        $card->updateNip($nip['TicketMessage']);
        $this->repository->update($card);

        $this->bus->publish(...$card->pullDomainEvents());
    }

    private function searchCredential(CardId $cardId): array
    {
        $credential = $this->queryBus->ask(new CardCredentialQuery($cardId->value()));
        return $credential->data;
    }
}