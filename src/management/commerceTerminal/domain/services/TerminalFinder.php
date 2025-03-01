<?php declare(strict_types=1);


namespace Viabo\management\commerceTerminal\domain\services;


use Viabo\management\commerceTerminal\domain\exceptions\TerminalNotExist;
use Viabo\management\commerceTerminal\domain\Terminal;
use Viabo\management\commerceTerminal\domain\TerminalRepository;
use Viabo\management\commerceTerminal\domain\TerminalView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class TerminalFinder
{
    public function __construct(private TerminalRepository $repository)
    {
    }

    public function __invoke(string $terminalId): Terminal
    {
        $terminal = $this->repository->search($terminalId);

        if (empty($terminal)) {
            throw new TerminalNotExist();
        }

        return $terminal;
    }

    public function searchViewCriteria(Filters $filters): TerminalView
    {
        $terminal = $this->repository->searchView(new Criteria($filters));

        if (empty($terminal)) {
            throw new TerminalNotExist();
        }

        return $terminal[0];

    }
}