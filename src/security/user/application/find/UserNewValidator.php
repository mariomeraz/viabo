<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\security\user\domain\exceptions\UserExist;
use Viabo\security\user\domain\exceptions\UserNameEmpty;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class UserNewValidator
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $userName, string $userEmail): void
    {
        if (empty($userName)) {
            throw new UserNameEmpty();
        }

        $filters = Filters::fromValues([
            ['field' => 'email', 'operator' => '=', 'value' => $userEmail]
        ]);
        $user = $this->repository->searchCriteria(new Criteria($filters));

        if (!empty($user)) {
            throw new UserExist();
        }
    }
}