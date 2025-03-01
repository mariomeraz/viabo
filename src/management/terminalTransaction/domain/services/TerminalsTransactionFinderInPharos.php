<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\domain\services;


use Viabo\management\terminalTransaction\domain\PharosTransactions;
use Viabo\shared\domain\Utils;

final readonly class TerminalsTransactionFinderInPharos
{
    public function __construct(private TerminalsTransactionFinderOnPharos $finderOnPharos)
    {
    }

    public function all(
        string  $credentialApikey ,
        array   $terminalsData ,
        string  $startDate ,
        string  $endDate ,
        ?string $page = null,
        ?string $pageSize = null
    ): PharosTransactions
    {
        $terminalsData = $this->extractTerminalData($terminalsData);

        $transactions = [];
        foreach ($terminalsData['merchantIds'] as $merchantId) {
            $pharosTransactions = $this->finderOnPharos->searchMerchantId(
                $credentialApikey ,
                $merchantId ,
                $terminalsData['terminals'] ,
                $startDate ,
                $endDate ,
                $page ,
                $pageSize
            );

            if (empty($pharosTransactions)) {
                continue;
            }

            $transactions = array_merge($transactions , $pharosTransactions);
        }

        return PharosTransactions::fromValues($transactions);
    }

    public function terminalId(
        string  $credentialApikey ,
        string  $terminalId ,
        array   $terminalsData ,
        string  $startDate ,
        string  $endDate ,
        ?string $page ,
        ?string $pageSize
    ): PharosTransactions
    {
        $terminalsData = $this->extractTerminalData($terminalsData);

        $transactions = $this->finderOnPharos->searchTerminalId(
            $credentialApikey ,
            $terminalId ,
            $terminalsData['terminals'] ,
            $startDate ,
            $endDate ,
            $page ,
            $pageSize
        );
        return PharosTransactions::fromValues($transactions);
    }

    private function extractTerminalData(array $terminalsData): array
    {
        $data = array_reduce($terminalsData , function ($data , $terminal) {
            $data['merchantIds'][] = $terminal['merchantId'];
            $data['terminals'][$terminal['terminalId']] = [
                'type' => $terminal['typeId'] ,
                'name' => $terminal['name'],
                'speiCard' => $terminal['speiCard'],
                'shared' => $terminal['shared']
            ];
            return $data;
        } , []);

        $data['merchantIds'] = Utils::removeDuplicateElements($data['merchantIds']);

        return $data;
    }
}