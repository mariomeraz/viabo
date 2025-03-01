<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\create_services_by_register_company;


use Viabo\backoffice\services\domain\events\ServicesCreatedDomainEventByRegisterCompany;
use Viabo\backoffice\services\domain\new\Service;
use Viabo\backoffice\services\domain\new\ServiceFactory;
use Viabo\backoffice\services\domain\new\ServiceRepository;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class ServicesCreatorByRegisterCompany
{
    public function __construct(private ServiceRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(array $company): void
    {
        if (intval($company['registerStep']) !== 2) {
            return;
        }

        $this->deleteRegisters($company['id']);

        $companyData = $this->companyData($company);
        $services = array_map(function (array $service) use ($companyData) {
            $service = array_merge($service, $companyData);
            $service = ServiceFactory::create($service);
            $this->repository->save($service);

            return $service->toArray();
        }, $company['services']);

        $this->bus->publish(new ServicesCreatedDomainEventByRegisterCompany($company['id'], $services));
    }

    private function deleteRegisters(string $companyId): void
    {
        $filters = Filters::fromValues([['field' => 'companyId', 'operator' => '=', 'value' => $companyId]]);
        $services = $this->repository->searchCriteria(new Criteria($filters));
        array_map(function (Service $service) {
            $this->repository->delete($service);
        }, $services);
    }

    public function companyData(array $company): array
    {
        return [
            'companyId' => $company['id'],
            'createdByUser' => $company['createdByUser'],
            'createDate' => $company['createDate']
        ];
    }
}