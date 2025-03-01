<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;



use Viabo\management\card\domain\services\CardFinder as CardFinderService;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardFinderBySpei
{
    public function __construct(private CardFinderService $finder)
    {
    }

    public function __invoke(string $speiCard): CardResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'spei.value' , 'operator' => '=' , 'value' => $speiCard ],
            ['field' => 'spei.value' , 'operator' => '<>' , 'value' => '' ]
        ]);
        $card = $this->finder->searchCriteria(new Criteria($filters));

        return new CardResponse($card->toArray());
    }
}