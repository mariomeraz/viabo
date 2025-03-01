<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_stp_admin_emails;


use Viabo\security\user\domain\events\StpAdminsEmailsFoundDomainEvent;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class StpAdminsEmailsFinder
{
    public function __construct(private UserRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(array $transaction): void
    {
        $stpAccountId = $transaction['additionalData']['stpAccountId'];
        $filters = Filters::fromValues([
            ['field' => 'profile.value', 'operator' => '=', 'value' => '5'],
            ['field' => 'businessId.value', 'operator' => '=', 'value' => $transaction['businessId']],
            ['field' => 'stpAccountId.value', 'operator' => '=', 'value' => $stpAccountId],
        ]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        $transaction['stpAdminsEmails'] = array_map(function (User $user) {
            return $user->email();
        }, $users);

        $this->bus->publish(new StpAdminsEmailsFoundDomainEvent($transaction['id'], $transaction));
    }
}