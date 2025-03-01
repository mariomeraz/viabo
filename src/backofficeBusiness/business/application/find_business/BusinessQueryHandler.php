<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\application\find_business;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class BusinessQueryHandler implements QueryHandler
{
    public function __construct(private BusinessFinder $finder)
    {
    }

    public function __invoke(BusinessQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId);
    }
}