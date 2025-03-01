<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FindUserQueryHandler implements QueryHandler
{
    public function __construct(private UserFinder $finder)
    {
    }

    public function __invoke(FindUserQuery $query): Response
    {
        return $this->finder->__invoke($query->userId, $query->userEmail);
    }
}