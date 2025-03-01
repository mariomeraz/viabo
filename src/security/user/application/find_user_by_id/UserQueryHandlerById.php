<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_user_by_id;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UserQueryHandlerById implements QueryHandler
{
    public function __construct(private UserFinderById $finder)
    {
    }

    public function __invoke(UserQueryById $query): Response
    {
        return $this->finder->__invoke($query->userId);
    }
}