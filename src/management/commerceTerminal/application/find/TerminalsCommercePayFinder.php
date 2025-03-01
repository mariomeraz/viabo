<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\application\find;

use Viabo\management\commerceTerminal\domain\services\TerminalsCommercePayCredentialFinder;
use Viabo\management\commerceTerminal\domain\TerminalCommerceId;

final readonly class TerminalsCommercePayFinder
{
    public function __construct (private TerminalsCommercePayCredentialFinder $finder)
    {
    }

    public function __invoke (TerminalCommerceId $commerceId, string $apiKey):FindTerminalsCommercePayResponse
    {
        $terminalsCommercePay = ($this->finder)($commerceId,$apiKey);
        return new FindTerminalsCommercePayResponse($terminalsCommercePay);
    }
}
