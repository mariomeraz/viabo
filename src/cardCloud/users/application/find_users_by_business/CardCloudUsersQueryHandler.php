<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\find_users_by_business;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudUsersQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudUsersFinder $finder)
    {
    }

    public function __invoke(CardCloudUsersQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId);
    }
}