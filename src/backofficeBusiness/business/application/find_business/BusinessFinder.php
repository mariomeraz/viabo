<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\application\find_business;


use Viabo\backofficeBusiness\business\application\BusinessResponse;
use Viabo\backofficeBusiness\business\domain\BusinessRepository;
use Viabo\backofficeBusiness\business\domain\exceptions\BusinessNotExist;

final readonly class BusinessFinder
{
    public function __construct(private BusinessRepository $repository)
    {
    }

    public function __invoke(string $businessId): BusinessResponse
    {
        $business = $this->repository->search($businessId);

        if (empty($business)) {
            throw new BusinessNotExist();
        }

        return new BusinessResponse($business->toArray());
    }
}