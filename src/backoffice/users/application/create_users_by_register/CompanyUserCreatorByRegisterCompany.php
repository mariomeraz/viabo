<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\create_users_by_register;


use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\backoffice\users\domain\events\CompanyUserCreatedDomainEventOnRegisterCompany;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyUserCreatorByRegisterCompany
{
    public function __construct(private CompanyUserRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(array $company): void
    {
        $user = CompanyUser::create(
            $company['id'],
            $company['user']['id'],
            $company['user']['profile'],
            $company['user']['name'],
            $company['user']['lastname'],
            $company['user']['email'],
            $company['createDate']
        );
        $this->repository->save($user);

        $company['users'] = [$user->toArray()];
        $this->bus->publish(new CompanyUserCreatedDomainEventOnRegisterCompany($company['id'], $company));
    }
}