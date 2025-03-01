<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_transactions_balance;


use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\stp\transaction\application\TransactionResponse;
use Viabo\stp\transaction\domain\exceptions\TransactionCreateDateRangeNotDefine;
use Viabo\stp\transaction\domain\Transaction;
use Viabo\stp\transaction\domain\TransactionRepository;

final readonly class TransactionsBalanceFinder
{
    public function __construct(private TransactionRepository $repository)
    {
    }

    public function __invoke(
        string $businessId,
        string $initialDate,
        string $endDate,
        string $account
    ): TransactionResponse
    {
        $this->ensureDates($initialDate, $endDate);
        $transactions = $this->searchTransactions($businessId, $initialDate, $endDate, $account);
        $speisIn = $this->filterSpeiIn($transactions);
        $totalSpeiInAmount = $this->calculateSpeiInTransactionTotalAmount($speisIn);
        $speisOut = $this->filterSpeiOut($transactions);
        $totalSpeiOutAmount = $this->calculateSpeiOutTransactionTotalAmount($speisOut);

        return new TransactionResponse([
            'speiInCount' => count($speisIn),
            'speiInTotal' => $totalSpeiInAmount,
            'speiOutCount' => count($speisOut),
            'speiOutTotal' => $totalSpeiOutAmount,
            'balance' => $totalSpeiInAmount - $totalSpeiOutAmount
        ]);
    }

    private function ensureDates(string $initialDate, string $endDate): void
    {
        if (empty($initialDate) || empty($endDate)) {
            throw new TransactionCreateDateRangeNotDefine();
        }
    }

    private function searchTransactions(string $businessId, string $initialDate, string $endDate, $account): array
    {
        $filters = Filters::fromValues([
            ['field' => 'businessId.value', 'operator' => '=', 'value' => $businessId],
            ['field' => 'createDate.value', 'operator' => '>=', 'value' => "$initialDate 00:00:00"],
            ['field' => 'createDate.value', 'operator' => '<=', 'value' => "$endDate 23:59:59"],
        ]);
        $filtersOr = Filters::fromValues([
            ['field' => 'sourceAccount.value', 'operator' => '=', 'value' => $account],
            ['field' => 'destinationAccount.value', 'operator' => '=', 'value' => $account]
        ]);

        $criteria = new Criteria($filters);
        $criteria->addOr($filtersOr);
        return $this->repository->searchCriteria($criteria);
    }

    public function filterSpeiIn(array $transactions): array
    {
        return array_filter($transactions, function (Transaction $transaction) {
            return $transaction->isSpeiIn();
        });
    }

    public function calculateSpeiInTransactionTotalAmount(array $speiIn): float
    {
        $amounts = array_map(function (Transaction $transaction) {
            return $transaction->amount();
        }, $speiIn);
        return array_sum($amounts);
    }

    public function filterSpeiOut(array $transactions): array
    {
        return array_filter($transactions, function (Transaction $transaction) {
            return $transaction->isSpeiOut();
        });
    }

    public function calculateSpeiOutTransactionTotalAmount(array $speiOut): float
    {
        $amounts = array_map(function (Transaction $transaction) {
            return $transaction->amount();
        }, $speiOut);
        return array_sum($amounts);
    }
}