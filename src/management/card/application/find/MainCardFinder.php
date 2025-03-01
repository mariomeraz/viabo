<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class MainCardFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CardCommerceId $commerceId , CardPaymentProcessorId $paymentProcessorId): MainCardIdResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId->value()] ,
            ['field' => 'main.value' , 'operator' => '=' , 'value' => '1'] ,
            ['field' => 'paymentProcessorId.value' , 'operator' => '=' , 'value' => $paymentProcessorId->value()] ,
            ['field' => 'active.value' , 'operator' => '=' , 'value' => '1']
        ]);

        $card = $this->repository->searchCriteria(new Criteria($filters));

        $data = empty($card) ? [
            'cardId' => '' ,
            'cardNumber' => ''
        ] : [
            'cardId' => $card[0]->id()->value() ,
            'cardNumber' => $card[0]->number()->value()
        ];

        return new MainCardIdResponse($data);
    }
}