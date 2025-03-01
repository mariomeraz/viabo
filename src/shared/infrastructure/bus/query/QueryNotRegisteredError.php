<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\bus\query;


use Viabo\shared\domain\bus\query\Query;
use RuntimeException;

final class QueryNotRegisteredError extends RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = $query::class;

        parent::__construct("The query <$queryClass> hasn't a query handler associated");
    }
}