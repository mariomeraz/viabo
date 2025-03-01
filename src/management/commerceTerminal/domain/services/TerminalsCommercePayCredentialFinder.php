<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\domain\services;

use Viabo\management\shared\domain\paymentGateway\PaymentGatewayAdapter;
use Viabo\management\commerceTerminal\domain\TerminalCommerceId;

final readonly class TerminalsCommercePayCredentialFinder
{
    public function __construct (private PaymentGatewayAdapter $adapter)
    {
    }

    public function __invoke (TerminalCommerceId $commerceId, string $apiKey):array
    {
        return $this->adapter->searchTerminalsBy($commerceId,$apiKey);
    }

}
