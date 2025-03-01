<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\application\find;

use Viabo\management\commerceTerminal\domain\services\TerminalsFinder as TerminalsFinderService;

final readonly class TerminalsFinder
{
    public function __construct(private TerminalsFinderService $finder)
    {
    }

    public function __invoke(string $commerceId): TerminalsResponse
    {
        $terminals = $this->finder->__invoke($commerceId);
        return new TerminalsResponse($terminals->toArray());
    }

}
