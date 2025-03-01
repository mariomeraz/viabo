<?php declare(strict_types=1);


namespace Viabo\management\card\domain\services;


use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\exceptions\CardsInsufficient;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardsFinderByAmount
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CardPaymentProcessorId $paymentProcessor , int $amount): array
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => ''] ,
            ['field' => 'paymentProcessorId.value' , 'operator' => '=' , 'value' => $paymentProcessor->value()] ,
            ['field' => 'ownerId.value' , 'operator' => '=' , 'value' => ''] ,
            ['field' => 'active.value' , 'operator' => '=' , 'value' => '1']
        ]);

        $cards = $this->repository->searchCriteria(new Criteria($filters , $amount));

        if (count($cards) < $amount) {
            throw new CardsInsufficient();
        }

        return $cards;
    }

}