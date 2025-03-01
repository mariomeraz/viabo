<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\backoffice\company\application\find\CommerceQuery;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\services\CardFinder;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class CardAssignerInCommerce
{
    public function __construct(
        private CardRepository $repository ,
        private QueryBus       $queryBus ,
        private CardFinder     $finder ,
        private EventBus       $bus
    )
    {
    }

    public function __invoke(CardId $cardId , CardCommerceId $commerceId): void
    {
        $this->ensureExist($commerceId);
        $card = ($this->finder)($cardId);

        $card->assignIn($commerceId);

        $this->repository->update($card);

        $this->bus->publish(...$card->pullDomainEvents());
    }

    private function ensureExist(CardCommerceId $commerceId): void
    {
        if ($commerceId->isNotEmpty()) {
            $this->queryBus->ask(new CommerceQuery($commerceId->value()));
        }
    }
}