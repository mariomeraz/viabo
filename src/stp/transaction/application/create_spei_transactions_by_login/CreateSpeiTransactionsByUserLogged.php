<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\create_spei_transactions_by_login;


use Viabo\security\user\domain\events\UserLoggedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\stp\stpAccount\application\create\BalanceStpAccountUpdater;
use Viabo\stp\stpAccount\application\find_stp_account_by_business\StpAccountFinderByBusiness;
use Viabo\stp\transaction\application\create_spei_out_transaction_by_stp\SpeiOutTransactionCreatorByStp;
use Viabo\stp\transaction\application\cretate_spei_in_transaction_by_stp\SpeiInTransactionCreatorByStp;

final class CreateSpeiTransactionsByUserLogged implements DomainEventSubscriber
{
    public function __construct(
        private StpAccountFinderByBusiness     $stpAccountFinderByBusiness,
        private SpeiOutTransactionCreatorByStp $speiOutTransactionCreator,
        private SpeiInTransactionCreatorByStp  $speiInTransactionCreator,
        private BalanceStpAccountUpdater       $balanceStpAccountUpdater
    )
    {
    }

    public static function subscribedTo(): array
    {
        return [UserLoggedDomainEvent::class];
    }

    public function __invoke(UserLoggedDomainEvent $event): void
    {
        $user = $event->toPrimitives();
        $stpAccount = $this->stpAccountFinderByBusiness->__invoke($user['businessId']);
        $company = $stpAccount->data['company'];
        try {
            $this->speiOutTransactionCreator->__invoke($company, true);
            $this->speiInTransactionCreator->__invoke($company, 0, true);
            $this->balanceStpAccountUpdater->__invoke($company, true);
        } catch (\DomainException) {
        }
    }
}