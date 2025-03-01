<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\backoffice\company\domain\services\CompanyFinder as CommerceFinderService;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CommerceFinderBySlug
{
    public function __construct(private CommerceFinderService $finder)
    {
    }

    public function __invoke(string $slug): CompanyResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'slug.value' , 'operator' => '=' , 'value' => $slug]
        ]);

        $commerce = $this->finder->searchCriteria(new Criteria($filter));
        return new CompanyResponse($commerce->toArray());
    }
}