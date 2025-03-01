<?php declare(strict_types=1);


namespace Viabo\management\commerceTerminal\application\find;


use Viabo\management\commerceTerminal\domain\services\TerminalsFinder;

final readonly class VirtualTerminalsFinder
{
    public function __construct(private TerminalsFinder $finder)
    {
    }

    public function __invoke(string $commerceId): TerminalsResponse
    {
        $terminals = $this->finder->__invoke($commerceId);
        $virtualTerminals = $terminals->virtual();
        return new TerminalsResponse($virtualTerminals->toArray());
    }

}