<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find_stp_account_by_number;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;
use Viabo\shared\domain\utils\Crypt;
use Viabo\stp\stpAccount\application\find_stp_account_by_criteria\StpAccountCriteriaFinder;

final readonly class StpAccountQueryHandlerByNumber implements QueryHandler
{
    public function __construct(private StpAccountCriteriaFinder $finder)
    {
    }

    public function __invoke(StpAccountQueryByNumber $query): Response
    {
        $filters = [['field' => 'number.value', 'operator' => '=', 'value' => Crypt::encrypt($query->stpNumber)]];

        if (!empty($query->businessId)) {
            $filters[] = ['field' => 'businessId.value', 'operator' => '=', 'value' => $query->businessId];
        }

        return $this->finder->__invoke($filters);
    }
}