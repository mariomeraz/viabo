<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\update_user_email_by_card_cloud;


use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\backoffice\users\domain\events\CompanyUserEmailUpdatedDomainEvent;
use Viabo\backoffice\users\domain\services\CompanyUsersFinder;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\shared\domain\Utils;

final readonly class CompanyUserEmailUpdater
{
    public function __construct(
        private CompanyUserRepository $repository,
        private CompanyUsersFinder    $usersFinder,
        private EventBus              $bus
    )
    {
    }

    public function __invoke(string $userId, string $email): void
    {
        $filters = Filters::fromValues([
            ['field' => 'userId.value', 'operator' => '=', 'value' => $userId]]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        $companies = array_map(function (CompanyUser $user) use ($email) {
            $user->updateEmail($email);
            $this->repository->save($user);
            return $user->companyId();
        }, $users);

        $companies = Utils::removeDuplicateElements($companies);
        array_map(function (string $companyId) {
            $users = $this->usersFinder->__invoke($companyId);
            $this->bus->publish(new CompanyUserEmailUpdatedDomainEvent(
                $companyId,
                ['id' => $companyId, 'users' => $users]
            ));
        }, $companies);
    }

}