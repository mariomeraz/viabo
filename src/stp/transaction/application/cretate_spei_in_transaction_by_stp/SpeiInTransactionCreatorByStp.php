<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\cretate_spei_in_transaction_by_stp;


use Viabo\backoffice\projection\application\find_company_by_bank_account\CompanyQueryByBankAccount;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\shared\domain\utils\DatePHP;
use Viabo\stp\shared\domain\stp\StpRepository;
use Viabo\stp\stpAccount\application\find\StpAccountQueryByCompany;
use Viabo\stp\stpAccount\application\find_stp_accounts\StpAccountsQuery;
use Viabo\stp\transaction\domain\services\AccountsDataFinder;
use Viabo\stp\transaction\domain\services\FormatStpData;
use Viabo\stp\transaction\domain\services\TransactionsCreatorByStp;
use Viabo\stp\transaction\domain\Transaction;
use Viabo\stp\transaction\domain\TransactionRepository;
use Viabo\stp\transaction\domain\Transactions;

final readonly class SpeiInTransactionCreatorByStp
{
    private DatePHP $date;

    public function __construct(
        private TransactionRepository    $repository,
        private StpRepository            $stpRepository,
        private AccountsDataFinder       $accountsDataFinder,
        private TransactionsCreatorByStp $transactionsCreator,
        private FormatStpData            $formatStpData,
        private QueryBus                 $queryBus,
        private EventBus                 $bus
    )
    {
        $this->date = new DatePHP();
    }

    public function __invoke(string $company, int $date, bool $stpAccountsDisable): void
    {
        $stpAccounts = $this->searchStpAccounts($company, $stpAccountsDisable);
        $transactions = $this->searchSpeiInsTransactions($date, $stpAccounts);
        $transactions = $this->filterSpeiInsNotRegistered($transactions);
        $transactions = $this->removeDuplicate($transactions);
        $transactions = $this->updateStpAccount($transactions);
        $transactions = $this->addCommissions($transactions);
        $transactions = $this->accountsDataFinder->addData($transactions);
        $transactions = $this->transactionsCreator->__invoke($transactions, 'speiIn');
        $this->save($transactions);
    }

    public function searchStpAccounts(string $company, bool $stpAccountsDisable): array
    {
        $stpAccounts = empty($company) ?
            $this->queryBus->ask(new StpAccountsQuery($stpAccountsDisable)) :
            $this->queryBus->ask(new StpAccountQueryByCompany($company, $stpAccountsDisable));
        return $stpAccounts->data;
    }

    public function searchSpeiInsTransactions(int $date, array $stpAccounts): array
    {
        $date = empty($date) ? $this->date->formatDateTime($this->date->dateTime(), 'Ymd') : strval($date);
        $transactions = [];
        foreach ($stpAccounts as $stpAccount) {
            try {
                $stpTransactions = $this->stpRepository->searchSpeiIn($stpAccount, $date);
                $stpTransactions = $this->formatStpData->__invoke($stpTransactions, $stpAccount);
            } catch (\DomainException) {
                continue;
            }
            $transactions = array_merge($transactions, $stpTransactions);
        }
        return $transactions;
    }

    private function filterSpeiInsNotRegistered(array $transactions): array
    {
        return array_filter($transactions, function (array $transaction) {
            $filter = Filters::fromValues([
                ['field' => 'stpId.value', 'operator' => '=', 'value' => $transaction['id']]
            ]);
            $transaction = $this->repository->searchCriteria(new Criteria($filter));
            return empty($transaction);
        });
    }

    private function removeDuplicate(array $transactions): array
    {
        $ids = [];
        return array_filter($transactions, function (array $transaction) use (&$ids) {
            if (!in_array($transaction['id'], $ids)) {
                $ids[] = $transaction['id'];
                return true;
            } else {
                return false;
            }
        });
    }

    private function updateStpAccount(array $transactions): array
    {
        return array_map(function (array $transaction) {
            $accountData = $this->accountsDataFinder->dataByAccount(
                $transaction['cuentaBeneficiario']
            );
            return array_merge($transaction, $accountData);
        }, $transactions);
    }

    private function addCommissions(array $transactions): array
    {
        return array_map(function (array $transaction) {
            $transaction['commissions'] = $this->searchCompanyCommissions($transaction['cuentaBeneficiario']);
            return $transaction;
        }, $transactions);
    }

    private function searchCompanyCommissions(string $bankAccountNumber): array
    {
        try {
            $company = $this->queryBus->ask(new CompanyQueryByBankAccount($bankAccountNumber));
            return $company->data['speiCommissions'];
        } catch (\DomainException) {
            return [
                'speiOut' => 0,
                'speiIn' => 0,
                'internal' => 0,
                'feeStp' => 0,
                'stpAccount' => 0,
                'total' => 0
            ];
        }
    }

    private function save(Transactions $transactions): void
    {
        $second = 0;
        array_map(function (Transaction $transaction) use (&$second) {
            $transaction->incrementReference($second++);
            $this->repository->save($transaction);
            $this->bus->publish(...$transaction->pullDomainEvents());
        }, $transactions->elements());
    }
}
