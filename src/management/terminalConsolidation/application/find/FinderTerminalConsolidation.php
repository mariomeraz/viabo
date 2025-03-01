<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\application\find;

use Viabo\management\shared\domain\commerce\CommerceId;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidation;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FinderTerminalConsolidation
{
    public function __construct(private TerminalConsolidationRepository $repository)
    {
    }

    public function __invoke(CommerceId $commerceId)
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId->value()],
        ]);

        $movementsTerminalConsolidation = $this->repository->searchCriteria(new Criteria($filters));

        $movementsTerminalConsolidation = empty($movementsTerminalConsolidation) ? [] : $movementsTerminalConsolidation;

        return new TerminalConsolidationResponse(array_map(function (TerminalConsolidation $terminalConsolidation){
            return $terminalConsolidation->toArray();
        }, $movementsTerminalConsolidation));
    }
}
