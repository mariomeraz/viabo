<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain\services;


use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\company\domain\exceptions\CompanyCommissionGreaterThanPercentage;
use Viabo\backoffice\company\domain\exceptions\CompanyCommissionLessThanZero;
use Viabo\backoffice\company\domain\exceptions\CompanyCommissionNotAllowed;
use Viabo\backoffice\company\domain\exceptions\CompanyFiscalNameExist;
use Viabo\backoffice\company\domain\exceptions\CompanyRFCExist;
use Viabo\backoffice\company\domain\exceptions\CompanyStpAccountEmpty;
use Viabo\backoffice\fee\application\find\RatesQuery;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompanyValidator
{
    public function __construct(private CompanyRepository $repository, private QueryBus $queryBus)
    {
    }

    public function ensureCompany(string $fiscalName, string $rfc, string $stpAccount): void
    {
        $this->ensureFiscalName($fiscalName);
        $this->ensureRfc($rfc);
        $this->ensureStpAccount($stpAccount);
    }

    public function ensureFiscalName(string $fiscalName, string $companyId = ''): void
    {
        $filter = [['field' => 'fiscalName.value', 'operator' => '=', 'value' => $fiscalName]];
        if (!empty($companyId)) {
            $filter[] = ['field' => 'id', 'operator' => '<>', 'value' => $companyId];
        }

        $filters = Filters::fromValues($filter);
        $company = $this->repository->searchCriteria(new Criteria($filters));

        if (!empty($company)) {
            throw new CompanyFiscalNameExist();
        }
    }

    public function ensureRfc(string $rfc): void
    {
        $filters = Filters::fromValues([['field' => 'rfc.value', 'operator' => '=', 'value' => $rfc]]);
        $company = $this->repository->searchCriteria(new Criteria($filters));
        if (!empty($company)) {
            throw new CompanyRFCExist();
        }
    }

    private function ensureStpAccount(string $stpAccount): void
    {
        if (empty($stpAccount)) {
            throw new CompanyStpAccountEmpty();
        }
    }

    public function ensureCommissions(array $commissions): void
    {
        $rates = $this->queryBus->ask(new RatesQuery());
        $this->ensureCommissionGreaterThanZero($commissions);
        $this->ensureCommissionPercentage($commissions, $rates->data['CommisionPercentage']);
        $this->ensureCommissionFeetStp($commissions['feeStp'], $rates->data['FeeStp']);
    }

    public function ensureCommissionGreaterThanZero(array $commissions): void
    {
        foreach ($commissions as $key => $commission) {
            if ($commission < 0) {
                throw new CompanyCommissionLessThanZero($key);
            }
        }
    }

    private function ensureCommissionPercentage(array $commissions, float $feet): void
    {
        foreach ($commissions as $key => $commission) {
            if ($key !== 'feeStp' && $commission > $feet && $feet != 0) {
                throw new CompanyCommissionGreaterThanPercentage($key, $feet);
            }
        }
    }

    private function ensureCommissionFeetStp(float $feetStp, float $feet): void
    {

        if ($feetStp > $feet && $feet != 0) {
            throw new CompanyCommissionNotAllowed($feet);
        }
    }

}