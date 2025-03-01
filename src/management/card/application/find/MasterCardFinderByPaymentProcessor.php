<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\exceptions\MasterCardNotSupported;
use Viabo\management\card\domain\services\CardsViewFinder;
use Viabo\shared\domain\criteria\Filters;

final readonly class MasterCardFinderByPaymentProcessor
{
    public function __construct(private CardsViewFinder $finder)
    {
    }

    public function __invoke(string $commerceId , string $paymentProcessorId): CardsResponse
    {
        $filters = [
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId] ,
            ['field' => 'paymentProcessorId' , 'operator' => '=' , 'value' => $paymentProcessorId] ,
            ['field' => 'main' , 'operator' => '=' , 'value' => '1'] ,
            ['field' => 'active' , 'operator' => '=' , 'value' => '1']
        ];

        $filters = Filters::fromValues($filters);
        $cards = $this->finder->searchCriteria($filters);

        if (empty($cards->count())) {
            throw new MasterCardNotSupported();
        }

        return new CardsResponse($cards->toArray());
    }
}