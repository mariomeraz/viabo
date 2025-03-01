<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_transactions_by_business;


use Viabo\shared\domain\utils\DatePHP;
use Viabo\stp\transaction\application\TransactionResponse;
use Viabo\stp\transaction\domain\Transaction;
use Viabo\stp\transaction\domain\TransactionRepository;

final readonly class TransactionsFinder
{
    public function __construct(private TransactionRepository $repository)
    {
    }

    public function __invoke(
        string $initialDate,
        string $endDate,
        string $account,
        int    $limit
    ): TransactionResponse
    {
        $transactions = $this->searchTransactions(
            $initialDate,
            $endDate,
            $account,
            $limit
        );
        return new TransactionResponse($transactions);
    }

    public function searchTransactions(
        string $initialDate,
        string $endDate,
        string $account,
        int    $limit
    ): array
    {
        $limit = empty($limit) ? null : $limit;
        $endDate = $this->setDefaultDateIfEmpty($endDate);
        $transactions = $this->repository->searchByAccount(
            "$initialDate 00:00:00",
            $endDate,
            $account,
            'DESC',
            $limit
        );

        return array_map(function (Transaction $transaction) {
            $data = $transaction->toArray();
            unset(
                $data['typeId'],
                $data['statusId'],
                $data['destinationEmail'],
                $data['createdByUser'],
                $data['apiData'],
                $data['active']
            );
            return $data;
        }, $transactions);
    }

    private function setDefaultDateIfEmpty(string $endDate): string
    {
        $date = new DatePHP();
        return empty($endDate) ? $date->dateTime() : "$endDate 23:59:59";
    }

}