<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\find;


use Viabo\management\terminalTransaction\domain\services\TerminalTransactionFinder as TerminalTransactionFinderService;

final readonly class TerminalTransactionFinder
{
    public function __construct(private TerminalTransactionFinderService $finder)
    {
    }

    public function __invoke(string $terminalTransactionId): TerminalTransactionResponse
    {
        $transaction = $this->finder->__invoke($terminalTransactionId);
        return new TerminalTransactionResponse($transaction->toArray());
    }


}