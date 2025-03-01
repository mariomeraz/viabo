<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\create_projection_by_created_company;


use Viabo\backoffice\company\domain\events\CompanyCreatedDomainEventByAdminStp;
use Viabo\backoffice\users\domain\events\CompanyUserCreatedDomainEventOnRegisterCompany;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateProjectionByCreatedCompany implements DomainEventSubscriber
{
    public function __construct(private CompanyProjectionCreator $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [
            CompanyUserCreatedDomainEventOnRegisterCompany::class,
            CompanyCreatedDomainEventByAdminStp::class
        ];
    }

    public function __invoke(
        CompanyUserCreatedDomainEventOnRegisterCompany|CompanyCreatedDomainEventByAdminStp $event
    ): void
    {
        $company = $this->formatData($event);
        $this->creator->__invoke($company);
    }

    private function formatData(
        CompanyUserCreatedDomainEventOnRegisterCompany|CompanyCreatedDomainEventByAdminStp $event
    ): array
    {
        $company = $event->toPrimitives();
        $company['createdByAdminStp'] = false;

        if ($event instanceof CompanyCreatedDomainEventByAdminStp) {
            $company['createdByAdminStp'] = true;
        }

        return $company;
    }
}