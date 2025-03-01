<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\stpAccount\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\find\CompaniesQueryByCostCenter;
use Viabo\backoffice\costCenter\application\find\CostCentersQueryByAdminUser;
use Viabo\backoffice\projection\application\find_companies_by_account_stp\CompaniesQueryByStpAccount;
use Viabo\backoffice\projection\application\find_companies_by_user\CompaniesQueryByUser;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\stpAccount\application\find\StpAccountQuery;
use Viabo\stp\stpAccount\application\find_stp_account_by_business\StpAccountQueryByBusiness;


final readonly class AccountsFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $accounts['sectionData'] = $this->defineSection($tokenData['profileId']);
            $accounts['stpAccounts'] = $this->searchStpAccounts($tokenData['businessId']);
            $accounts['costCenters'] = $this->searchCostCenters($tokenData['id']);
            $accounts['companies'] = $this->searchCompanies($tokenData['id'], $tokenData['businessId']);

            return new JsonResponse($this->opensslEncrypt($accounts));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    private function defineSection(string $profileId): string
    {
        return match ($profileId) {
            '5' => 'stpAccounts',
            '6' => 'costCenters',
            '7' => 'companies',
            default => ''
        };
    }

    public function searchStpAccounts(string $businessId): array
    {
        $stpAccount = $this->ask(new StpAccountQueryByBusiness($businessId));
        $companies = $this->ask(new CompaniesQueryByStpAccount($stpAccount->data['id']));
        $data['id'] = $stpAccount->data['id'];
        $data['name'] = $stpAccount->data['company'];
        $data['account'] = $stpAccount->data['number'];
        $data['balance'] = $stpAccount->data['balance'];
        $data['balanceDate'] = $stpAccount->data['balanceDate'];
        $data['pendingCharges'] = $stpAccount->data['pendingCharges'];
        $data['companiesBalance'] = array_sum(array_map(function (array $company) {
            return $company['balance'];
        }, $companies->data));
        $data['availableBalance'] = $data['balance'] - $data['companiesBalance'];
        $data['companies'] = $this->formatCompanies($companies->data);
        return [$data];
    }

    public function searchCostCenters(string $userId): array
    {
        $costCenters = $this->ask(new CostCentersQueryByAdminUser($userId));
        return array_map(function (array $costCenter) {
            $data['id'] = $costCenter['id'];
            $data['name'] = $costCenter['name'];
            $companies = $this->ask(new CompaniesQueryByCostCenter($costCenter['id']));
            $data['companies'] = $this->formatCompanies($companies->data);
            return $data;
        }, $costCenters->data);
    }

    private function searchCompanies(string $userId, string $businessId): array
    {
        $companies = $this->ask(new CompaniesQueryByUser($userId, $businessId));
        return array_values(array_map(function (array $company) {
            $stpAccount = '';
            if (!empty($company['stpAccountId'])) {
                $stpAccount = $this->ask(new StpAccountQuery($company['stpAccountId']));
                $stpAccount = $stpAccount->data['number'];
            }
            unset($company['commissions']['updatedByUser'], $company['commissions']['stpAccount']);
            return [
                'id' => $company['id'],
                'name' => $company['fiscalName'],
                'balance' => floatval($company['balance']),
                'account' => implode(',', $company['bankAccounts']),
                'commissions' => $company['commissions'],
                'stpAccount' => $stpAccount
            ];
        }, $companies->data));
    }

    function formatCompanies(array $companies): array
    {
        return array_values(array_map(function (array $company) {
            unset($company['commissions']['updatedByUser'], $company['commissions']['stpAccount']);
            return [
                'id' => $company['id'],
                'name' => $company['fiscalName'],
                'balance' => floatval($company['balance']),
                'account' => implode(',', $company['bankAccounts']),
                'commissions' => $company['commissions']
            ];
        }, $companies));
    }

}