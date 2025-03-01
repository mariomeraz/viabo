<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UserPermissionQueryHandler implements QueryHandler
{
    public function __construct(private UserPermissionsFinder $finder)
    {
    }

    public function __invoke(UserPermissionQuery $query): Response
    {
        return $this->finder->__invoke($query->userId);
    }
}