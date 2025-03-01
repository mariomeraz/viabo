<?php declare(strict_types=1);


namespace Viabo\backoffice\commerceUser\application\find;


use Viabo\backoffice\commerceUser\domain\CommerceUserKey;
use Viabo\backoffice\commerceUser\domain\CommerceUserRepository;
use Viabo\backoffice\commerceUser\domain\exceptions\CommerceUserNotExist;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CommerceFinderByUser
{
    public function __construct(private CommerceUserRepository $repository)
    {
    }

    public function __invoke(CommerceUserKey $userId): CommerceUserResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'userId.value' , 'operator' => '=' , 'value' => $userId->value() ]
        ]);

        $commerceUser = $this->repository->searchCriteria(new Criteria($filter));

        if(empty($commerceUser)){
            throw new CommerceUserNotExist();
        }

        return new CommerceUserResponse($commerceUser[0]->toArray());
    }
}