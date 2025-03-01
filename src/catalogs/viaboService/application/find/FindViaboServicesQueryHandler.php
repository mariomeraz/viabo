<?php declare(strict_types=1);


namespace Viabo\catalogs\viaboService\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FindViaboServicesQueryHandler implements QueryHandler
{
    public function __construct(private ViaboServicesFinder $finder)
    {
    }

    public function __invoke(FindViaboServicesQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}