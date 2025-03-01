<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_by_register;


use Viabo\backoffice\projection\domain\CompanyProjectionRepository;

final readonly class ProjectionUpdaterByRegisterCompany
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(array $company): void
    {
        $projection = $this->repository->search($company['id']);
        $projection->updateByClient(
            $company['fiscalPersonType'],
            $company['fiscalName'],
            $company['tradeName'],
            $company['rfc'],
            $company['registerStep']
        );
        $this->repository->update($projection);
    }
}