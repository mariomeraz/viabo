<?php declare(strict_types=1);

namespace Viabo\backoffice\services\domain\services\create_card_cloud;

use Viabo\backoffice\services\domain\new\ServiceFactory;
use Viabo\backoffice\services\domain\new\ServiceRepository;
use Viabo\cardCloud\subAccount\application\create_sub_account\CardCloudSubAccountCreatorQuery;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class CardCloudServiceCreator
{
    public function __construct(
        private ServiceRepository $repository,
        private QueryBus          $queryBus,
    )
    {
    }

    public function __invoke(array $company): array
    {
        $company['type'] = '5';
        $cardCloudResponse = $this->createSubAccount($company['businessId'], $company['id'], $company['rfc']);
        $company['serviceCardCloud'] = $cardCloudResponse;
        $service = ServiceFactory::create($company);
        $this->repository->save($service);
        return $service->toArray();
    }

    private function createSubAccount(string $businessId, string $companyId, string $rfc): array
    {
        $cardCloudResponse = $this->queryBus->ask(new CardCloudSubAccountCreatorQuery($businessId, $companyId, $rfc));
        return $cardCloudResponse->data;
    }
}
