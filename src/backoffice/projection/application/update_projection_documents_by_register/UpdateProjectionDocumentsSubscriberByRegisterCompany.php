<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_documents_by_register;


use Viabo\backoffice\documents\domain\events\DocumentCreatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateProjectionDocumentsSubscriberByRegisterCompany implements DomainEventSubscriber
{
    public function __construct(private ProjectionDocumentsUpdaterByRegisterCompany $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [DocumentCreatedDomainEvent::class];
    }

    public function __invoke(DocumentCreatedDomainEvent $event): void
    {
        $companyId = $event->aggregateId();
        $documents = $event->toPrimitives();
        $this->updater->__invoke($companyId, $documents);
    }
}