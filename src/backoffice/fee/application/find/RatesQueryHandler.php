<?php declare(strict_types=1);


namespace Viabo\backoffice\fee\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class RatesQueryHandler implements QueryHandler
{
    public function __construct(private RatesFinder $finder)
    {
    }

    public function __invoke(RatesQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}