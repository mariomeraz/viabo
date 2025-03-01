<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\domain\services\find_company;


use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\backoffice\projection\domain\exceptions\CompanyProjectionNotExist;

final readonly class CompanyProjectionFinder
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $companyId): CompanyProjection
    {
        $company = $this->repository->search($companyId);

        if (empty($company)) {
            throw new CompanyProjectionNotExist();
        }

        return $company;
    }
}