<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\application\find;

use Viabo\management\commerceTerminal\domain\exceptions\TerminalSpeiCardNotAssigned;
use Viabo\management\commerceTerminal\domain\TerminalRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final class TerminalFinderBySpeiCard
{
    public function __construct(public TerminalRepository $repository)
    {
    }

    public function __invoke(string $terminalId): FindTerminalSpeiCardResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'terminalId' , 'operator' => '=' , 'value' => $terminalId] ,
        ]);

        $terminals = $this->repository->searchView(new Criteria($filters));

        if (empty($terminals)) {
            throw new TerminalSpeiCardNotAssigned();
        }

        return new FindTerminalSpeiCardResponse($terminals[0]->toArray());
    }
}
