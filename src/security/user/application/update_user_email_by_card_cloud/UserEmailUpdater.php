<?php declare(strict_types=1);


namespace Viabo\security\user\application\update_user_email_by_card_cloud;


use Viabo\security\user\domain\exceptions\UserEmailExist;
use Viabo\security\user\domain\services\UserFinder;
use Viabo\security\user\domain\services\UserPasswordReset;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class UserEmailUpdater
{
    public function __construct(
        private UserRepository    $repository,
        private UserFinder        $finder,
        private UserPasswordReset $passwordReset
    )
    {
    }

    public function __invoke(string $userId, string $email): void
    {
        $this->ensureEmail($email);

        $user = $this->finder->__invoke($userId);
        $user->updateEmail($email);
        $this->repository->update($user);

        $this->passwordReset->__invoke($userId);
    }

    private function ensureEmail(string $email): void
    {
        $filters = Filters::fromValues([['field' => 'email', 'operator' => '=', 'value' => $email]]);
        $user = $this->repository->searchCriteria(new Criteria($filters));

        if (!empty($user)) {
            throw new UserEmailExist();
        }
    }
}