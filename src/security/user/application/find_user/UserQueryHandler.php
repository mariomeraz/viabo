<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_user;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UserQueryHandler implements QueryHandler
{
    public function __construct(private UserFinder $finder)
    {
    }

    public function __invoke(UserQuery $query): Response
    {
        return $this->finder->__invoke($query->userId, $query->businessId);
    }
}