<?php declare(strict_types=1);

namespace Viabo\backoffice\users\application\find_company_card_holders;

use Viabo\backoffice\users\application\CompanyUserResponse;
use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompanyCardHoldersFinder
{
    public function __construct(private CompanyUserRepository $repository)
    {
    }

    public function __invoke(string $companyId): CompanyUserResponse
    {
        $filters =
            Filters::fromValues([
                ['field' => 'companyId', 'operator' => '=', 'value' => $companyId],
                ['field' => 'profileId.value', 'operator' => '=', 'value' => '8']
            ]);
        $users = $this->repository->searchCriteria(new Criteria($filters));
        return new CompanyUserResponse(array_map(function (CompanyUser $user) {
            return $user->toArray();
        }, $users));
    }
}
