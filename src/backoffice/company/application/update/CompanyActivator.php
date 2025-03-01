<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update;


use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\company\domain\exceptions\CompanyNotExist;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyActivator
{
    public function __construct(private CompanyRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(string $userId, string $companyId, bool $active): void
    {
        $company = $this->repository->search($companyId);

        if(empty($company)){
            throw new CompanyNotExist();
        }

        $company->updateActive($active, $userId);
        $this->repository->update($company);

        $this->bus->publish(...$company->pullDomainEvents());
    }
}