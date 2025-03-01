<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;



use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CommercesAffiliatesFinder
{
    public function __construct(private CompanyRepository $repository)
    {
    }

    public function __invoke(): CommercesAffiliatesResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'statusId' , 'operator' => '=' , 'value' => '3' ]
        ]);
        $commerces = $this->repository->searchViewCriteria(new Criteria($filters));

        return new CommercesAffiliatesResponse(array_map(function (CompanyProjection $commerce){
            return $commerce->toArrayForCatalog();
        },$commerces));
    }
}