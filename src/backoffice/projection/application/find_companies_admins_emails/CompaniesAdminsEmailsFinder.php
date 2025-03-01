<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_admins_emails;


use Viabo\backoffice\company\domain\events\CompaniesAdminsFoundDomainEvent;
use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompaniesAdminsEmailsFinder
{
    public function __construct(private CompanyProjectionRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(array $transaction): void
    {
        $filters = Filters::fromValues([
            ['field' => 'services', 'operator' => 'CONTAINS', 'value' => $transaction['sourceAccount']]
        ]);
        $companies = $this->repository->searchCriteria(new Criteria($filters));

        $transaction['emails'] = [];
        array_map(function (CompanyProjection $projection) use (&$transaction) {
            $transaction['emails'] = array_merge($transaction['emails'], $projection->adminEmails());
        }, $companies);

        $this->bus->publish(new CompaniesAdminsFoundDomainEvent($transaction['id'], $transaction));
    }
}
