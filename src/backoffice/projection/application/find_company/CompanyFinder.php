<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company;


use Viabo\backoffice\projection\application\CompanyProjectionResponse;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\backoffice\projection\domain\exceptions\CompanyProjectionNotExist;

final readonly class CompanyFinder
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $companyId): CompanyProjectionResponse
    {

        $company = $this->repository->search($companyId);

        if (empty($company)) {
            throw new CompanyProjectionNotExist();
        }

        return new CompanyProjectionResponse($company->toArrayOld());
    }
}