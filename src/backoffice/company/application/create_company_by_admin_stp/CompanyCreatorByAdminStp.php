<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\create_company_by_admin_stp;


use Viabo\backoffice\company\domain\Company;
use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\company\domain\events\CompanyCreatedDomainEventByAdminStp;
use Viabo\backoffice\company\domain\services\CompanyValidator;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyCreatorByAdminStp
{
    public function __construct(
        private CompanyRepository      $repository,
        private CompanyValidator       $validator,
        private EventBus               $bus
    )
    {
    }

    public function __invoke(
        string $userId,
        string $businessId,
        string $companyId,
        string $fiscalName,
        string $commercialName,
        string $rfc,
        string $stpAccount,
        array  $users,
        array  $costCenters,
        array  $commissions
    ): void
    {
        $this->validator->ensureCompany($fiscalName, $rfc, $stpAccount);
        $this->validator->ensureCommissions($commissions);
        $folio = $this->repository->searchFolioLast();

        $company = Company::createByAdminStp(
            $userId,
            $businessId,
            $companyId,
            $folio,
            $fiscalName,
            $commercialName,
            $rfc
        );
        $this->repository->save($company);

        $data = array_merge(
            $company->toArray(),
            [
                'users' => $users,
                'costCenters' => $costCenters,
                'commissions' => $commissions,
                'stpAccount' => $stpAccount
            ]
        );

        $this->bus->publish(new CompanyCreatedDomainEventByAdminStp($company->id(), $data));
    }

}