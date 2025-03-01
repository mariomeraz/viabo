<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\domain\services;


use Viabo\management\shared\domain\paymentGateway\PaymentGatewayAdapter;
use Viabo\management\terminalTransaction\domain\PharosMessage;

final readonly class TerminalsTransactionFinderOnPharos
{
    public function __construct(private PaymentGatewayAdapter $adapter)
    {
    }

    public function searchTerminalId(
        string  $apiKey ,
        string  $terminalId ,
        array   $terminalsData ,
        string  $startDate ,
        string  $endDate ,
        ?string $page ,
        ?string $pageSize
    ): array
    {
        $queryParams = $this->createQueryParams(
            $startDate ,
            $endDate ,
            '' ,
            $terminalId ,
            $page ,
            $pageSize
        );

        $transactions = $this->adapter->searchTerminalTransactions($queryParams , $apiKey);
        return empty($transactions['items']) ? [] : $this->format($transactions['items'] , $terminalsData);
    }

    public function searchMerchantId(
        string  $apiKey ,
        string  $merchantId ,
        array   $terminalsData ,
        string  $startDate ,
        string  $endDate ,
        ?string $page ,
        ?string $pageSize
    ): array
    {
        $queryParams = $this->createQueryParams(
            $startDate ,
            $endDate ,
            $merchantId ,
            '' ,
            $page ,
            $pageSize
        );

        $transactions = $this->adapter->searchTerminalTransactions($queryParams , $apiKey);
        return empty($transactions['items']) ? [] : $this->format($transactions['items'] , $terminalsData);
    }

    private function createQueryParams(
        string  $startDate ,
        string  $endDate ,
        ?string $merchantId ,
        ?string $terminalId ,
        ?string $page ,
        ?string $pageSize
    ): string
    {
        $params = [
            'fromDate' => $startDate ,
            'toDate' => $endDate ,
            empty($merchantId) ? '' : 'merchantId' => $merchantId ,
            empty($terminalId) ? '' : 'terminalId' => $terminalId ,
            'page' => empty($page) ? '1' : $page ,
            'pageSize' => empty($pageSize) ? '10000' : $pageSize
        ];

        return http_build_query($params);
    }

    private function format(array $transactions , array $terminals): array
    {
        $items = [];
        foreach ($transactions as $data) {
            if (isset($terminals[$data["terminal_id"]])) {
                $data['message'] = PharosMessage::message($data['result_code']);
                $data['terminal_name'] = $terminals[$data["terminal_id"]]['name'];
                $data['terminal_type'] = $terminals[$data["terminal_id"]]['type'];
                $data['terminal_speiCard'] = $terminals[$data["terminal_id"]]['speiCard'];
                $data['terminal_shared'] = $terminals[$data["terminal_id"]]['shared'];
                $items[] = $data;
            }
        }
        return $items;
    }

}