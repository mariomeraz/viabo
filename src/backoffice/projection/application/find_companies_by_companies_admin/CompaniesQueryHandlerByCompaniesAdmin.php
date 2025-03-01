<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_by_companies_admin;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompaniesQueryHandlerByCompaniesAdmin implements QueryHandler
{
    public function __construct(private CompaniesFinderByCompaniesAdmin $finder)
    {
    }

    public function __invoke(CompaniesQueryByCompaniesAdmin $command): Response
    {
        return $this->finder->__invoke($command->userId, $command->businessId, $command->profileId);
    }
}