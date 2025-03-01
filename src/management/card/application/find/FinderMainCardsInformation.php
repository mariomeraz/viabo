<?php declare(strict_types=1);

namespace Viabo\management\card\application\find;

use Viabo\management\card\domain\CardInformationView;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\exceptions\CardInformationNotFound;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FinderMainCardsInformation
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CardCommerceId $commerceId):MainCardsInformationResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId->value()],
            ['field' => 'main' , 'operator' => '=' , 'value' => '1'],
            ['field' => 'active' , 'operator' => '=' , 'value' => '1']
        ]);

        $cardInformation = $this->repository->searchCardInformationView(new Criteria($filters));

        return new MainCardsInformationResponse(array_map(function (CardInformationView $card) {
            return $card->toArray();
        } , $cardInformation));

    }
}
