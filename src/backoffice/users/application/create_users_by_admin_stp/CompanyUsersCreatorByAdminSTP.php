<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\create_users_by_admin_stp;


use Viabo\backoffice\users\domain\events\CompanyUsersCreatedDomainEventByAdminStp;
use Viabo\backoffice\users\domain\services\CompanyUserCreator;
use Viabo\backoffice\users\domain\services\CompanyUsersFinder;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyUsersCreatorByAdminSTP
{
    public function __construct(
        private CompanyUserCreator $creator,
        private CompanyUsersFinder $usersFinder,
        private EventBus           $bus
    )
    {
    }

    public function __invoke(array $company): void
    {
        array_map(function (string $userId) use ($company) {
            $this->creator->__invoke($userId, $company['id'], $company['businessId']);
        }, $company['users']);

        $company['users'] = $this->usersFinder->__invoke($company['id']);
        $this->bus->publish(new CompanyUsersCreatedDomainEventByAdminStp($company['id'], $company));
    }
}