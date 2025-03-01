<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\delete_commissions_by_admin_stp;


use Viabo\backoffice\commission\domain\Commission;
use Viabo\backoffice\commission\domain\CommissionRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CommissionSpeiDeleter
{
    public function __construct(private CommissionRepository $repository)
    {
    }

    public function __invoke(string $companyId): void
    {
        $filters = Filters::fromValues([
            ['field' => 'companyId' , 'operator' => '=' , 'value' => $companyId ]
        ]);
        $commissions = $this->repository->searchCriteria(new Criteria($filters));

        array_map(function (Commission $commission) {
            $this->repository->delete($commission);
        }, $commissions);
    }
}