<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\application\find_business_by_criteria;


use Viabo\backofficeBusiness\business\application\BusinessResponse;
use Viabo\backofficeBusiness\business\domain\Business;
use Viabo\backofficeBusiness\business\domain\BusinessRepository;
use Viabo\backofficeBusiness\business\domain\exceptions\BusinessNotExist;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class BusinessFinderByCriteria
{
    public function __construct(private BusinessRepository $repository)
    {
    }

    public function __invoke(array $filters): BusinessResponse
    {
        $filters = Filters::fromValues($filters);
        $business = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($business)) {
            throw new BusinessNotExist();
        }

        return new BusinessResponse(array_map(function (Business $business) {
            return $business->toArray();
        }, $business));
    }
}