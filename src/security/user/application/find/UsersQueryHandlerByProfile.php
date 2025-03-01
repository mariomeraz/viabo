<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UsersQueryHandlerByProfile implements QueryHandler
{
    public function __construct(private UsersFinderByCriteria $finder)
    {
    }

    public function __invoke(UsersQueryByProfile $query): Response
    {
        $filters = [
            ['field' => 'profile.value' , 'operator' => '=' , 'value' => $query->userProfileId ],
            ['field' => 'active.value' , 'operator' => '=' , 'value' => '1' ]
        ];
        return $this->finder->__invoke($filters);
    }
}