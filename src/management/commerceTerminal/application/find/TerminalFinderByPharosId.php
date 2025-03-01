<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\application\find;

use Viabo\management\commerceTerminal\domain\exceptions\TerminalsNotFound;
use Viabo\management\commerceTerminal\domain\TerminalRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class TerminalFinderByPharosId
{
    public function __construct(private TerminalRepository $repository)
    {
    }

    public function __invoke(string $merchantId): TerminalMerchantIdResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'terminalId' , 'operator' => '=' , 'value' => $merchantId]
        ]);
        $terminals = $this->repository->searchView(new Criteria($filters));

        if (empty($terminals)) {
            throw new TerminalsNotFound();
        }

        return new TerminalMerchantIdResponse($terminals[0]->toArray());
    }
}

