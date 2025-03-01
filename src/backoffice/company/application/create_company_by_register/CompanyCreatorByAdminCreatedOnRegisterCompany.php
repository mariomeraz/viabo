<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\create_company_by_register;


use Viabo\backoffice\company\domain\Company;
use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\company\domain\events\CompanyCreatedDomainEventByAdminCreatedOnRegisterCompany;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyCreatorByAdminCreatedOnRegisterCompany
{
    public function __construct(private CompanyRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(array $administrator): void
    {
        $folioLast = $this->repository->searchFolioLast();
        $company = Company::createFromClient(
            $administrator['id'],
            $administrator['businessId'],
            $folioLast
        );
        $this->repository->save($company);

        $company = array_merge($company->toArray(), ['user' => $administrator]);
        $this->bus->publish(new CompanyCreatedDomainEventByAdminCreatedOnRegisterCompany($company['id'], $company));
    }

}