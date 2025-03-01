<?php declare(strict_types=1);


namespace Viabo\backoffice\users\domain\services;


use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompanyUsersFinder
{
    public function __construct(private CompanyUserRepository $repository)
    {
    }

    public function __invoke(string $companyId): array
    {
        $filters = Filters::fromValues([['field' => 'companyId', 'operator' => '=', 'value' => $companyId]]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        return array_map(function (CompanyUser $user) {
            return $user->toArray();
        }, $users);
    }
}