<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\assign_user_in_company;


use Viabo\backoffice\company\domain\exceptions\CompanyNotExist;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\backoffice\users\domain\events\CompanyUserCreatedDomainEventOnAssign;
use Viabo\backoffice\users\domain\services\CompanyUserCreator;
use Viabo\backoffice\users\domain\services\CompanyUsersFinder;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyUserAssigner
{
    public function __construct(
        private CompanyUserRepository $repository,
        private CompanyUserCreator    $creator,
        private CompanyUsersFinder    $usersFinder,
        private EventBus              $bus
    )
    {
    }

    public function __invoke(string $businessId, string $companyId, string $userId): void
    {
        $this->ensureCompany($companyId);
        $this->creator->__invoke($userId, $companyId, $businessId);
        $users = $this->usersFinder->__invoke($companyId);

        $this->bus->publish(new CompanyUserCreatedDomainEventOnAssign(
            $companyId,
            ['id' => $companyId, 'users' => $users]
        ));
    }

    private function ensureCompany(string $companyId): void
    {
        $company = $this->repository->search($companyId);
        if (empty($company)) {
            throw new CompanyNotExist();
        }
    }

}