<?php declare(strict_types=1);


namespace Viabo\security\user\application\reset_password_by_url;


use Viabo\security\user\domain\services\UserPasswordReset;

final readonly class UserPasswordUpdaterByUrl
{
    public function __construct(private UserPasswordReset $updater)
    {
    }

    public function __invoke(string $userId): void
    {
        $this->updater->__invoke($userId);
    }
}