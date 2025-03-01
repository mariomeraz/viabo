<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_by_user;


use Viabo\backoffice\company\application\find\CompanyResponse;
use Viabo\shared\domain\bus\query\QueryHandler;

final readonly class CompanyQueryHandlerByUser implements QueryHandler
{
    public function __construct(private CompanyFinderByUser $finder)
    {
    }

    public function __invoke(CompanyQueryByUser $command): CompanyResponse
    {
        return $this->finder->__invoke($command->userId, $command->businessId, $command->profileId);
    }
}