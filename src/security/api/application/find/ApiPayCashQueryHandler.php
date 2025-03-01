<?php declare(strict_types=1);


namespace Viabo\security\api\application\find;


use Viabo\security\api\domain\ApiName;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class ApiPayCashQueryHandler implements QueryHandler
{
    public function __construct(private ApiFinder $finder)
    {
    }

    public function __invoke(ApiQuery $query): Response
    {
        $name = ApiName::create($query->apiName);
        return $this->finder->__invoke($name);
    }
}