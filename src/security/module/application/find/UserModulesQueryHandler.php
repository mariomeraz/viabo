<?php declare(strict_types=1);


namespace Viabo\security\module\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UserModulesQueryHandler implements QueryHandler
{
    public function __construct(private UserModulesFinder $finder)
    {
    }

    public function __invoke(UserModulesQuery $query): Response
    {
        return $this->finder->__invoke($query->userPermissions , $query->companyServices);
    }
}