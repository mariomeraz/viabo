<?php declare(strict_types=1);


namespace Viabo\stp\bank\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class BanksQueryHandler implements QueryHandler
{
    public function __construct(private BanksFinder $finder)
    {
    }

    public function __invoke(BanksQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}