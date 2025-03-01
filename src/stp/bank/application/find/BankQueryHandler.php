<?php declare(strict_types=1);


namespace Viabo\stp\bank\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class BankQueryHandler implements QueryHandler
{
    public function __construct(private BankFinder $finder)
    {
    }

    public function __invoke(BankQuery $query): Response
    {
        return $this->finder->__invoke($query->bankId);
    }
}