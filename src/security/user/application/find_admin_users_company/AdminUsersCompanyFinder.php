<?php declare(strict_types=1);

namespace Viabo\security\user\application\find_admin_users_company;

use Viabo\security\user\application\find\UserResponse;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class AdminUsersCompanyFinder
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $businessId):UserResponse
    {
        $filters = Filters::fromValues([
                ['field' => 'businessId.value', 'operator' => '=', 'value' => $businessId],
                ['field' => 'profile.value', 'operator' => '=', 'value' => '7'],
        ]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        return new UserResponse(array_map(function (User $user) {
            $data = $user->toArray();
            unset($data['password'],$data['stpAccountId']);
            return $data;
        }, $users));
    }
}
