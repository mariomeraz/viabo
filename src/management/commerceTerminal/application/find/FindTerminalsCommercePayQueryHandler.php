<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\application\find;

use Viabo\management\commerceTerminal\domain\TerminalCommerceId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FindTerminalsCommercePayQueryHandler implements QueryHandler
{
    public function __construct (private TerminalsCommercePayFinder $finder)
    {
    }

    public function __invoke (FindTerminalsCommercePayQuery $query):Response
    {
        $merchantId = TerminalCommerceId::create($query->merchantId);
        $apiKey = $query->apiKey;

        return ($this->finder)($merchantId,$apiKey);
    }
}
