<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UserQueryHandlerByUsername implements QueryHandler
{
    public function __construct(private UserFinderByCriteria $finder)
    {
    }

    public function __invoke(UserQueryByUsername $query): Response
    {
        $filters = [['field' => 'email', 'operator' => '=', 'value' => $query->username]];
        return $this->finder->__invoke($filters, true);
    }
}