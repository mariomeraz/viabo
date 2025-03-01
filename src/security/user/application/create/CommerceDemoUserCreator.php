<?php declare(strict_types=1);


namespace Viabo\security\user\application\create;


use Viabo\security\shared\domain\user\UserEmail;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserName;
use Viabo\security\user\domain\UserPhone;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CommerceDemoUserCreator
{
    public function __construct(
        private UserRepository $repository ,
        private EventBus       $bus
    )
    {
    }

    public function __invoke(UserName $name , UserEmail $email , UserPhone $phone): void
    {
        $user = User::demo($name , $email , $phone);
        $this->repository->save($user);

        $this->bus->publish(...$user->pullDomainEvents());
    }

}