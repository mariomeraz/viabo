<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\services;


use Viabo\shared\domain\utils\DatePHP;
use Viabo\stp\transaction\domain\Transaction;
use Viabo\stp\transaction\domain\TransactionRepository;

final readonly class StatementAccountFinder
{
    public function __construct(
        private TransactionRepository $repository,
        private DatePHP               $datePHP
    )
    {
    }

    public function __invoke(
        int $account,
        int $month,
        int $year
    ): array
    {
        $date = empty($month) || empty($year) ? '' : "$year-$month-01";
        $firstDay = $this->datePHP->firstDayMonth($date);
        $lastDay = $this->datePHP->lastDayMonth($date);
        $initialDate = "$firstDay 00:00:00";
        $endDate = "$lastDay 23:59:59";
        $account = strval($account);
        $transactions = $this->repository->searchByAccount($initialDate, $endDate, $account, 'ASC', null);
        $transactions = $this->filtersLiquidated($transactions);
        return $this->formatData($transactions);
    }

    private function filtersLiquidated(array $transactions): array
    {
        return array_values(array_filter($transactions, function (Transaction $transaction) {
            return $transaction->isLiquidated();
        }));
    }

    public function formatData(array $transactions): array
    {
        return array_map(function (Transaction $transaction) {
            $data = $transaction->toArray();
            $data['typeName'] = $transaction->isSpeiIn() ? 'Entrada' : 'Salida';
            $data['commissions'] = $transaction->commissionsTotal();
            $data['total'] = $transaction->amountTotal();
            $data['bankName'] = '';
            return $data;
        }, $transactions);
    }

}