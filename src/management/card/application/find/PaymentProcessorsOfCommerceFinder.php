<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardOwnerId;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\CardView;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\shared\domain\Utils;

final readonly class PaymentProcessorsOfCommerceFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CardCommerceId $commerceId , CardOwnerId $ownerId , string $userProfileId): CardsResponse
    {
        $filters = Filters::fromValues($this->filters($commerceId , $ownerId , $userProfileId));
        $cards = $this->repository->searchView(new Criteria($filters));

        $paymentProcessors = array_map(function (CardView $card) {
            $data = $card->toArray();
            return ['id' => $data['paymentProcessorId'] , 'name' => $data['paymentProcessorName']];
        } , $cards);

        return new CardsResponse(Utils::removeDuplicateElements($paymentProcessors));
    }

    private function filters(CardCommerceId $commerceId , CardOwnerId $ownerId , string $userProfileId): array
    {
        $enabledStatus = '5';
        $profileLegalRepresentative = '3';
        if ($userProfileId === $profileLegalRepresentative) {
            return [
                ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId->value()] ,
                ['field' => 'statusId' , 'operator' => '=' , 'value' => $enabledStatus] ,
                ['field' => 'main' , 'operator' => '=' , 'value' => '1'],
                ['field' => 'active' , 'operator' => '=' , 'value' => '1']
            ];
        }

        return [
            ['field' => 'ownerId' , 'operator' => '=' , 'value' => $ownerId->value()] ,
            ['field' => 'statusId' , 'operator' => '=' , 'value' => $enabledStatus],
            ['field' => 'active' , 'operator' => '=' , 'value' => '1']
        ];
    }
}