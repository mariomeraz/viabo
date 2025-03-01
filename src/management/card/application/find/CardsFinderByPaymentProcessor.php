<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\shared\domain\commerce\CommerceId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardsFinderByPaymentProcessor
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CommerceId $commerceId, CardPaymentProcessorId $paymentProcessorId): CardsResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId->value()],
            ['field' => 'paymentProcessorId.value' , 'operator' => '=' , 'value' => $paymentProcessorId->value()]
        ]);

        $cards = $this->repository->searchCriteria(new Criteria($filter));
        return new CardsResponse(array_map(function (Card $card){
            return $card->number()->value();
        }, $cards));
    }
}