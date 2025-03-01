<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update_company_by_admin_stp;


use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\company\domain\events\CompanyUpdatedDomainEventByAdminStp;
use Viabo\backoffice\company\domain\exceptions\CompanyNotExist;
use Viabo\backoffice\company\domain\services\CompanyValidator;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyUpdaterByAdminStp
{
    public function __construct(
        private CompanyRepository $repository,
        private CompanyValidator  $validator,
        private EventBus          $bus
    )
    {
    }

    public function __invoke(
        string $userId,
        string $companyId,
        string $fiscalName,
        string $tradeName,
        string $stpAccountId,
        array  $users,
        array  $costCenters,
        array  $commissions
    ): void
    {
        $this->validator->ensureFiscalName($fiscalName, $companyId);
        $this->validator->ensureCommissions($commissions);

        $company = $this->repository->search($companyId);

        if (empty($company)) {
            throw new CompanyNotExist();
        }

        $company->updateByAdminStp($userId, $fiscalName, $tradeName);
        $this->repository->update($company);

        $data = array_merge(
            $company->toArray(),
            [
                'users' => $users,
                'costCenters' => $costCenters,
                'commissions' => $commissions,
                'stpAccount' => $stpAccountId
            ]
        );
        $this->bus->publish(new CompanyUpdatedDomainEventByAdminStp($company->id(), $data));
    }
}