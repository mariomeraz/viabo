<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_subaccount_card_cloud_by_company;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudSubAccountQueryHandlerByCompany implements QueryHandler
{
    public function __construct(private CardCloudSubAccountFinderByCompany $finder)
    {
    }

    public function __invoke(CardCloudSubAccountQueryByCompany $query): Response
    {
        return $this->finder->__invoke($query->companyId);
    }
}