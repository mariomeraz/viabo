<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\find;


use Viabo\management\terminalTransaction\domain\CommercePayView;
use Viabo\management\terminalTransaction\domain\services\TerminalsTransactionFinderInPharos;
use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class SharedTerminalsTransactionsFinder
{
    public function __construct(
        private TerminalTransactionRepository      $repository ,
        private TerminalsTransactionFinderInPharos $finderInPharos
    )
    {
    }

    public function __invoke(
        string $commerceId ,
        string $apikey ,
        array  $terminals ,
        string $startDate ,
        string $endDate
    ): TerminalsTransactionResponse
    {
        $terminalsIds = $this->filterIds($terminals);
        $terminalsTransaction = $this->searchTerminalsTransactions($terminalsIds , $commerceId);
        $transactionsReferences = $this->filterReferences($terminalsTransaction);
        $pharosTransactions = $this->finderInPharos->all(
            $apikey ,
            $terminals ,
            $startDate ,
            $endDate
        );
        $pharosTransactions = $pharosTransactions->filterLiquidationTransactionsByReferences($transactionsReferences);
        $pharosTransactions->addAdditionalData($terminalsTransaction);
        return new TerminalsTransactionResponse($pharosTransactions->toArray());
    }

    private function filterIds(array $terminals): array
    {
        return array_map(function (array $terminal) {
            return $terminal['terminalId'];
        } , $terminals);
    }

    private function searchTerminalsTransactions(array $terminalsIds , string $commerceId): array
    {
        $filter = Filters::fromValues([
            ['field' => 'terminalId' , 'operator' => 'IN' , 'value' => implode(',' , $terminalsIds)] ,
            ['field' => 'commerceId' , 'operator' => '<>' , 'value' => $commerceId],
            ['field' => 'statusId' , 'operator' => '=' , 'value' => '7'],
            ['field' => 'liquidationStatusId' , 'operator' => 'IN' , 'value' => '12,13'],
        ]);
        $transactions = $this->repository->searchCriteriaView(new Criteria($filter));

        return array_map(function (CommercePayView $transaction) {
            return $transaction->toArray();
        } , $transactions);
    }

    private function filterReferences(array $terminalsTransaction): array
    {
        return array_map(function (array $terminal) {
            return $terminal['reference'];
        } , $terminalsTransaction);
    }
}