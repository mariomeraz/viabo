<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find_stp_account_by_criteria;


use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\stp\stpAccount\application\find\StpAccountResponse;
use Viabo\stp\stpAccount\domain\StpAccount;
use Viabo\stp\stpAccount\domain\StpAccountRepository;

final readonly class StpAccountCriteriaFinder
{
    public function __construct(private StpAccountRepository $repository)
    {
    }

    public function __invoke(array $filters): StpAccountResponse
    {
        $filters = Filters::fromValues($filters);
        $account = $this->repository->searchCriteria(new Criteria($filters));
        return new StpAccountResponse(array_map(function (StpAccount $account) {
            return $account->decrypt();
        }, $account));
    }
}