<?php declare(strict_types=1);

namespace Viabo\management\card\application\find;

use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\shared\domain\commerce\CommerceId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FinderCardsNumber
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CommerceId $commerceId): CardsNumberResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId->value()],
        ]);

        $cards = $this->repository->searchCriteria(new Criteria($filter));
        $cardsNumber = array_map(function (Card $card){
            return [
                'cardNumber' => $card->number()->value(),
                'paymentProcessorId' => $card->paymentProcessorId()->value()
            ];
        }, $cards);

        $cardsPaymentProcessor = [];

        foreach ($cardsNumber as $item) {

            $paymentProcessorId = $item['paymentProcessorId'];

            $cardsPaymentProcessor[$paymentProcessorId][]= $item['cardNumber'];

        }
        return new CardsNumberResponse($cardsPaymentProcessor);
    }
}
