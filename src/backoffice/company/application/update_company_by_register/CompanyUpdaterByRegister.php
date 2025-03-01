<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update_company_by_register;


use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\company\domain\events\CompanyUpdatedDomainEventByRegister;
use Viabo\backoffice\company\domain\services\EnsureBusinessRules;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyUpdaterByRegister
{

    public function __construct(
        private CompanyRepository   $repository,
        private EnsureBusinessRules $businessRules,
        private EventBus            $bus
    )
    {
    }

    public function __invoke(
        string      $companyId,
        string|null $fiscalPersonType,
        string      $fiscalName,
        string      $tradeName,
        string      $rfc,
        string      $registerStep,
        array       $services
    ): void
    {
        $this->ensureTradeName($tradeName, $companyId, $registerStep);
        $company = $this->repository->search($companyId);

        $company->updateByClient(
            $fiscalPersonType,
            $fiscalName,
            $tradeName,
            $rfc,
            $registerStep
        );
        $this->repository->update($company);
        $company = array_merge($company->toArray(), ['services' => $services]);

        $this->bus->publish(new CompanyUpdatedDomainEventByRegister($company['id'], $company));
    }

    private function ensureTradeName(string $tradeName, string $companyId, string $registerStep): void
    {
        if (intval($registerStep) === 3) {
            $this->businessRules->ensureTradeName($companyId, $tradeName);
        }
    }

}