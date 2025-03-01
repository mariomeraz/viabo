<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_documents_by_register;


use Viabo\backoffice\projection\domain\CompanyProjectionRepository;

final readonly class ProjectionDocumentsUpdaterByRegisterCompany
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $companyId, array $documents): void
    {
        $projection = $this->repository->search($companyId);

        if (empty($projection)) {
            return;
        }

        $projection->updateDocuments($documents);
        $this->repository->update($projection);
    }
}