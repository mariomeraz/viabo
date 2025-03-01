<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\find_service_by_card_cloud_subAccount;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class ServiceCardCloudQueryHandlerBySubAccount implements QueryHandler
{
    public function __construct(private ServiceCardCloudFinderBySubAccount $finder)
    {
    }

    public function __invoke(ServiceCardCloudQueryBySubAccount $query): Response
    {
        return $this->finder->__invoke($query->subAccountId);
    }
}