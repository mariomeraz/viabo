<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\services\UserPasswordUpdater as UserPasswordUpdaterService;
use Viabo\security\user\domain\UserPassword;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class SendUserPassword
{
    public function __construct(private UserPasswordUpdaterService $updater , private EventBus $bus)
    {
    }

    public function __invoke(
        UserId       $userId ,
        UserPassword $password ,
        string       $cardNumber ,
        array        $commerce
    ): void
    {
        $legalRepresentativeData = [
            'name' => $commerce['legalRepresentativeName'] ,
            'email' => $commerce['legalRepresentativeEmail']
        ];
        $user = $this->updater->__invoke($userId , $password);
        $user->setEventSendPassword($cardNumber , $legalRepresentativeData);

        $this->bus->publish(...$user->pullDomainEvents());
    }
}