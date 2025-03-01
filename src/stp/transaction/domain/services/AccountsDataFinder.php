<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\services;


use Viabo\backoffice\projection\application\find_company_by_bank_account\CompanyQueryByBankAccount;
use Viabo\security\user\application\find\AdministratorsStpQuery;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\stp\bank\application\find\BankQuery;
use Viabo\stp\externalAccount\application\find\ExternalAccountQuery;
use Viabo\stp\stpAccount\application\find\StpAccountQuery;
use Viabo\stp\stpAccount\application\find_stp_account_by_number\StpAccountQueryByNumber;

final readonly class AccountsDataFinder
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(string $businessId, array $accounts, bool $isInternalTransaction): array
    {
        if ($isInternalTransaction) {
            return $this->companies($accounts);
        } else {
            return $this->externalAccounts($accounts, $businessId);
        }
    }

    public function externalAccounts(array $externalAccounts, string $businessId): array
    {
        return array_map(function (array $externalAccount) use ($businessId) {
            $account = $this->getBankAccountData($externalAccount['bankAccount'], $businessId);
            if ($this->isInternalAccount($account)) {
                $externalAccount['isInternalTransaction'] = true;
            } else {
                $externalAccount['isInternalTransaction'] = false;
                $account = $this->queryBus->ask(new ExternalAccountQuery($externalAccount['bankAccount']));
                $bank = $this->queryBus->ask(new BankQuery($account->data['bankId']));
                $account = array_merge($bank->data, $account->data);
            }
            return $this->addAccountData($externalAccount, $account);
        }, $externalAccounts);
    }

    public function searchCompany(string $bankAccount, string $businessId): array
    {
        try {
            $company = $this->queryBus->ask(new CompanyQueryByBankAccount($bankAccount, $businessId));
            return $company->data;
        } catch (\DomainException) {
            return ['id' => '', 'balance' => floatval(0), 'rfc' => '', 'fiscalName' => '', 'users' => []];
        }
    }

    public function addData(array $transactions): array
    {
        return array_map(function (array $transaction) {
            $sourceCompany = $this->companies([
                ['bankAccount' => $transaction['cuentaOrdenante'], 'businessId' => $transaction['businessId']]
            ]);
            $destinationCompany = $this->companies([
                ['bankAccount' => $transaction['cuentaBeneficiario'], 'businessId' => $transaction['businessId']]
            ]);
            $data = ['sourceCompany' => $sourceCompany[0], 'destinationCompany' => $destinationCompany[0]];
            return array_merge($transaction, $data, ['commissions' => $transaction['commissions'] ?? []]);
        }, $transactions);
    }

    private function companies(array $companies): array
    {
        return array_map(function (array $company) {
            $company['isInternalTransaction'] = true;
            $businessId = $company['businessId'] ?? '';
            $bankAccountData = $this->getBankAccountData($company['bankAccount'], $businessId);
            return $this->addAccountData($company, $bankAccountData);
        }, $companies);
    }

    private function getBankAccountData(string $bankAccount, string $businessId): array
    {
        $stpAccount = $this->queryBus->ask(new StpAccountQueryByNumber($bankAccount, $businessId));
        if (!empty($stpAccount->data)) {
            $data = $stpAccount->data[0];
            $businessId = empty($businessId) ? $data['businessId'] : $businessId;
            $admins = $this->queryBus->ask(new AdministratorsStpQuery($businessId));
            return [
                'type' => 'stpAccount',
                'companyId' => '',
                'balance' => $data['balance'],
                'rfc' => '',
                'beneficiary' => $data['company'],
                'emails' => $this->getEmails($admins->data)
            ];
        } else {
            $companyData = $this->searchCompany($bankAccount, $businessId);
            return [
                'type' => 'company',
                'companyId' => $companyData['id'],
                'balance' => $companyData['balance'],
                'rfc' => $companyData['rfc'],
                'beneficiary' => $companyData['fiscalName'],
                'emails' => $this->getEmails($companyData['users'])
            ];
        }
    }

    private function getEmails(array $users): string
    {
        $emails = array_map(function (array $user) {
            return $user['email'];
        }, $users);

        return implode(',', $emails);
    }

    private function isInternalAccount(array $bankAccountData): bool
    {
        return !empty($bankAccountData['companyId']);
    }

    private function addAccountData(array $account, array $data): array
    {
        $account['type'] = $data['type'] ?? 'externalAccount';
        $account['companyId'] = $data['companyId'] ?? '';
        $account['balance'] = $data['balance'] ?? 0;
        $account['rfc'] = $data['rfc'];
        $account['bankAccount'] = $data['interbankCLABE'] ?? $account['bankAccount'];
        $account['beneficiary'] = $data['beneficiary'];
        $account['email'] = $data['email'] ?? $data['emails'];
        $account['bankName'] = $data['shortName'] ?? '';
        $account['bankCode'] = $data['code'] ?? '';
        return $account;
    }

    public function dataByAccount(string $account): array
    {
        $stpAccount = $this->queryBus->ask(new StpAccountQueryByNumber($account));

        if (!empty($stpAccount->data)) {
            return [
                'stpAccountId' => $stpAccount->data[0]['id'],
                'stpAccountNumber' => $stpAccount->data[0]['number'],
                'stpAccountBalance' => $stpAccount->data[0]['balance'],
                'businessId' => $stpAccount->data[0]['businessId']
            ];
        }

        $company = $this->searchCompany($account, '');

        if (empty($company['id'])) {
            return [
                'stpAccountId' => '',
                'stpAccountNumber' => '',
                'stpAccountBalance' => '0',
                'businessId' => ''
            ];
        }

        $stpAccount = $this->queryBus->ask(new StpAccountQuery($company['stpAccountId']));
        return [
            'stpAccountId' => $stpAccount->data['id'],
            'stpAccountNumber' => $stpAccount->data['number'],
            'stpAccountBalance' => $stpAccount->data['balance'],
            'businessId' => $stpAccount->data['businessId']
        ];
    }

}