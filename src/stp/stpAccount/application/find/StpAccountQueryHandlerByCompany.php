<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class StpAccountQueryHandlerByCompany implements QueryHandler
{
    public function __construct(private StpAccountFinderByCriteria $finder)
    {
    }

    public function __invoke(StpAccountQueryByCompany $query): Response
    {
        $stpAccountActive = $query->stpAccountsDisable ? '0' : '1';
        $filter = [
            ['field' => 'company.value', 'operator' => '=', 'value' => $query->company],
            ['field' => 'active.value', 'operator' => '=', 'value' => $stpAccountActive]
        ];
        return $this->finder->__invoke($filter);
    }
}