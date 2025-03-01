<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\find;


use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CommercePayQueryHandler implements QueryHandler
{
    public function __construct(private CommercePayFinder $finder)
    {
    }

    public function __invoke(CommercePayQuery $query): Response
    {
        $commercePayId = CommercePayId::create($query->payId);
        return $this->finder->__invoke($commercePayId);
    }
}