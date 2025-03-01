<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardOwnerId;
use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\CardView;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class EnabledCardsFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(
        CardCommerceId         $commerceId ,
        CardOwnerId            $ownerId ,
        CardPaymentProcessorId $paymentProcessorId ,
        string                 $userProfileId
    ): CardsResponse
    {
        $enabledStatus = '5';
        $filters = [
            ['field' => 'statusId' , 'operator' => '=' , 'value' => $enabledStatus] ,
            ['field' => 'main' , 'operator' => '=' , 'value' => '0'] ,
            ['field' => 'paymentProcessorId' , 'operator' => '=' , 'value' => $paymentProcessorId->value()],
            ['field' => 'active' , 'operator' => '=' , 'value' => '1']
        ];

        $LegalRepresentativeProfile = '3';
        if ($userProfileId === $LegalRepresentativeProfile) {
            $filters[] = ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId->value()];
        } else {
            $filters[] = ['field' => 'ownerId' , 'operator' => '=' , 'value' => $ownerId->value()];
        }

        $filters = Filters::fromValues($filters);
        $cards = $this->repository->searchView(new Criteria($filters));

        return new CardsResponse(array_map(function (CardView $card) {
            return $card->toArray();
        } , $cards));
    }

}