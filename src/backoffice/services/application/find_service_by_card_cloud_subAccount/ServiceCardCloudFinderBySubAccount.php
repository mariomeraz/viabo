<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\find_service_by_card_cloud_subAccount;


use Viabo\backoffice\services\application\ServiceResponse;
use Viabo\backoffice\services\domain\exceptions\ServiceCardCloudSubAccountNotExist;
use Viabo\backoffice\services\domain\new\ServiceRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class ServiceCardCloudFinderBySubAccount
{
    public function __construct(private ServiceRepository $repository)
    {
    }

    public function __invoke(string $subAccountId): ServiceResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'subAccountId.value', 'operator' => '=', 'value' => $subAccountId]
        ]);
        $service = $this->repository->searchServiceCardCloud(new Criteria($filters));

        if(empty($service)){
            throw new ServiceCardCloudSubAccountNotExist();
        }

        return new ServiceResponse($service[0]->toArray());
    }
}