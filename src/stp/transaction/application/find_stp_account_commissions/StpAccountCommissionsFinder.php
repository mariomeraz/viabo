<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_stp_account_commissions;


use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\shared\domain\criteria\Order;
use Viabo\shared\domain\utils\DatePHP;
use Viabo\stp\transaction\application\TransactionResponse;
use Viabo\stp\transaction\domain\Transaction;
use Viabo\stp\transaction\domain\TransactionRepository;

final readonly class StpAccountCommissionsFinder
{
    public function __construct(
        private TransactionRepository $repository,
        private DatePHP               $datePHP
    )
    {
    }

    public function __invoke(string $businessId, string $startDay, string $endDay): TransactionResponse
    {
        $startDay = empty($startDay) ? $this->datePHP->firstDayMonth() : $startDay;
        $endDay = empty($endDay) ? $this->datePHP->now() : $endDay;

        $filters = Filters::fromValues([
            ['field' => 'commissions.value', 'operator' => '<>', 'value' => ""],
            ['field' => 'businessId.value', 'operator' => '=', 'value' => $businessId],
            ['field' => 'createDate.value', 'operator' => '>=', 'value' => "$startDay 00:00:00"],
            ['field' => 'createDate.value', 'operator' => '<=', 'value' => "$endDay 23:59:59"]
        ]);
        $criteria = new Criteria($filters, Order::fromValues('liquidationDate.value', 'asc'));
        $transactions = $this->repository->searchCriteria($criteria);

        $transactions = $this->filtersLiquidated($transactions);
        $transactions = $this->filtersCommissionNotEmpty($transactions);

        return new TransactionResponse($this->formatData($transactions));
    }

    private function filtersLiquidated(array $transactions): array
    {
        return array_values(array_filter($transactions, function (Transaction $transaction) {
            return $transaction->isLiquidated();
        }));
    }

    private function filtersCommissionNotEmpty(array $transactions): array
    {
        return array_values(array_filter($transactions, function (Transaction $transaction) {
            return abs($transaction->commissionsTotal()) > 0;
        }));
    }

    public function formatData(array $transactions): array
    {
        return array_map(function (Transaction $transaction) {
            $data = $transaction->toArray();
            $data['sourceName'] = trim($data['sourceName']);
            $data['destinationName'] = trim($data['destinationName']);
            $data['typeName'] = $transaction->isSpeiIn() ? 'Entrada' : 'Salida';
            $data['speiOut'] = $data['commissions']['speiOut'];
            $data['speiIn'] = $data['commissions']['speiIn'];
            $data['internal'] = $data['commissions']['internal'];
            $data['feeStp'] = $data['commissions']['feeStp'];
            $data['totalCommission'] = $transaction->amountTotal();
            $data['bankName'] = '';
            return $this->deleteData($data);
        }, $transactions);
    }

    function deleteData(array $data): array
    {
        unset(
            $data['businessId'],
            $data['typeId'],
            $data['statusId'],
            $data['sourceEmail'],
            $data['destinationEmail'],
            $data['amountMoneyFormat'],
            $data['commissions'],
            $data['urlCEP'],
            $data['receiptUrl'],
            $data['apiData'],
            $data['createdByUser'],
            $data['createDate'],
            $data['active'],
            $data['additionalData']
        );
        return $data;
    }
}