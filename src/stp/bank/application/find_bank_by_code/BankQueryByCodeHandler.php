<?php declare(strict_types=1);


namespace Viabo\stp\bank\application\find_bank_by_code;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class BankQueryByCodeHandler implements QueryHandler
{
    public function __construct(private BankFinderByCode $finder)
    {
    }

    public function __invoke(BankQueryByCode $query): Response
    {
        return $this->finder->__invoke($query->bankCode);
    }
}