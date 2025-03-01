<?php declare(strict_types=1);


namespace Viabo\management\commerceTerminal\application\find;



use Viabo\management\commerceTerminal\domain\services\TerminalFinder as TerminalFinderService;
use Viabo\shared\domain\criteria\Filters;

final readonly class TerminalFinder
{
    public function __construct(private TerminalFinderService $finder)
    {
    }

    public function __invoke(string $terminalId): TerminalResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'id' , 'operator' => '=' , 'value' => $terminalId ]
        ]);
        $terminal = $this->finder->searchViewCriteria($filter);
        return new TerminalResponse($terminal->toArray());
    }
}