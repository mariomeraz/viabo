<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\backoffice\company\application\find\CommerceQuery;
use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\services\CardsFinderByAmount;
use Viabo\management\paymentProcessor\application\find\FindPaymentProcessorQuery;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class CardsAssignerInCommerce
{
    public function __construct(
        private CardRepository      $repository ,
        private QueryBus            $queryBus ,
        private EventBus            $bus ,
        private CardsFinderByAmount $cardsFinderByAmount
    )
    {
    }

    public function __invoke(
        CardCommerceId $commerceId , CardPaymentProcessorId $paymentProcessor , int $amount
    ): void
    {
        $this->ensureExist($commerceId , $paymentProcessor);
        $cards = ($this->cardsFinderByAmount)($paymentProcessor , $amount);

        array_map(function (Card $card) use ($commerceId) {
            $card->assignIn($commerceId);
            $this->repository->update($card);

            $this->bus->publish(...$card->pullDomainEvents());
        } , $cards);
    }

    private function ensureExist(CardCommerceId $commerceId , CardPaymentProcessorId $paymentProcessor): void
    {
        $this->queryBus->ask(new CommerceQuery($commerceId->value()));
        $this->queryBus->ask(new FindPaymentProcessorQuery($paymentProcessor->value()));
    }
}