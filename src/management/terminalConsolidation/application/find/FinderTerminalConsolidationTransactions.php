<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\application\find;

use Viabo\management\terminalConsolidation\domain\TerminalConsolidation;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FinderTerminalConsolidationTransactions
{
    public function __construct(private TerminalConsolidationRepository $repository)
    {
    }

    public function __invoke(array $terminals , string $terminalId): TerminalConsolidationTransactionsResponse
    {
        $filters = [['field' => 'terminalId.value' , 'operator' => '=' , 'value' => $terminalId]];

        if (empty($terminalId)) {
            $terminalsIds = $this->filterTerminalsIds($terminals);
            $filters = [['field' => 'terminalId.value' , 'operator' => 'IN' , 'value' => implode(',' , $terminalsIds)]];
        }

        $filters = Filters::fromValues($filters);

        $consolidations = $this->repository->searchCriteria(new Criteria($filters));

        return new TerminalConsolidationTransactionsResponse(
            array_map(function (TerminalConsolidation $terminalConsolidation) {
                return $terminalConsolidation->toArray();
            } , $consolidations)
        );
    }

    private function filterTerminalsIds(array $terminals): array
    {
        return array_map(function (array $terminal) {
            return $terminal['terminalId'];
        } , $terminals);
    }
}
