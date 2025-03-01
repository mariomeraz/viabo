<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_user_by_register;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UserQueryHandlerByRegisterCompany implements QueryHandler
{
    public function __construct(private UserFinderByRegisterCompany $finder)
    {
    }

    public function __invoke(UserQueryByRegisterCompany $command): Response
    {
        return $this->finder->__invoke($command->username);
    }
}