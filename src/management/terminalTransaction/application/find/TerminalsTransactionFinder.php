<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\find;

use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;
use Viabo\management\terminalTransaction\domain\CommercePayView;
use Viabo\management\terminalTransaction\domain\PharosTransactions;
use Viabo\management\terminalTransaction\domain\services\TerminalsTransactionFinderInPharos;
use Viabo\management\terminalTransactionLog\domain\exceptions\TerminalIdNotExistInCommerce;
use Viabo\management\terminalTransactionLog\domain\exceptions\TerminalTransactionCredentialApiKeyNotExist;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\shared\domain\Utils;

final readonly class TerminalsTransactionFinder
{

    public function __construct(
        private TerminalTransactionRepository      $repository ,
        private TerminalsTransactionFinderInPharos $finderInPharos
    )
    {
    }

    public function __invoke(
        string  $commerceId ,
        string  $credentialApikey ,
        string  $terminalId ,
        array   $terminals ,
        ?array  $conciliations ,
        string  $startDate ,
        string  $endDate ,
        ?string $page ,
        ?string $pageSize
    ): TerminalsTransactionResponse
    {
        $this->ensureCredentialApiKey($credentialApikey);
        $this->ensureTerminalId($terminalId , $terminals);
        $conciliatedIds = $this->searchConciliatedIds($conciliations);
        $transactionReferences = $this->searchTransactionReferencesBy($commerceId);

        $pharosTransactions = $this->searchPharosTransactions(
            $terminalId ,
            $credentialApikey ,
            $terminals ,
            $startDate ,
            $endDate ,
            $page ,
            $pageSize
        );
        $pharosTransactions->setConciliations($conciliatedIds);
        $pharosTransactions = $pharosTransactions->filterTransactionReferences($transactionReferences);

        return new TerminalsTransactionResponse([
            "movements" => $pharosTransactions->toArray() ,
            "pager" => ["total" => $pharosTransactions->count()]
        ]);
    }

    private function ensureCredentialApiKey(string $credentialApikey): void
    {
        if (empty($credentialApikey)) {
            throw new TerminalTransactionCredentialApiKeyNotExist();
        }
    }

    private function ensureTerminalId(string $terminalId , array $terminalsData): void
    {
        if (empty($terminalId)) {
            return;
        }

        $terminalsIds = array_reduce($terminalsData , function (array $ids , array $terminal) {
            $ids[] = $terminal['terminalId'];
            return $ids;
        } , []);

        if (!in_array($terminalId , $terminalsIds)) {
            throw new TerminalIdNotExistInCommerce();
        }
    }

    private function searchConciliatedIds(?array $conciliatedTransactions): array
    {
        $ids = array_map(function (array $conciliatedTransaction) {
            return $conciliatedTransaction['transactionId'];
        } , $conciliatedTransactions);

        return Utils::removeDuplicateElements($ids);
    }

    private function searchPharosTransactions(
        string  $terminalId ,
        string  $credentialApikey ,
        array   $terminalsData ,
        string  $startDate ,
        string  $endDate ,
        ?string $page ,
        ?string $pageSize
    ): PharosTransactions
    {
        if (empty($terminalId)) {
            return $this->finderInPharos->all(
                $credentialApikey ,
                $terminalsData ,
                $startDate ,
                $endDate ,
                $page ,
                $pageSize
            );
        }
        return $this->finderInPharos->terminalId(
            $credentialApikey ,
            $terminalId ,
            $terminalsData ,
            $startDate ,
            $endDate ,
            $page ,
            $pageSize
        );
    }

    private function searchTransactionReferencesBy(string $commerceId): array
    {
        $filter = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId]
        ]);
        $transactions = $this->repository->searchCriteriaView(new Criteria($filter));

        return array_map(function (CommercePayView $transaction) {
            return $transaction->reference();
        } , $transactions);
    }

}