<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\application\create_documents_by_register_company;


use Viabo\backoffice\documents\domain\Document;
use Viabo\backoffice\documents\domain\DocumentRepository;
use Viabo\backoffice\documents\domain\events\DocumentCreatedDomainEvent;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class DocumentsCreatorByRegisterCompany
{
    public function __construct(private DocumentRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(string $companyId, array $uploadDocuments): void
    {
        $documents = [];
        unset($uploadDocuments['commerceId']);
        foreach ($uploadDocuments as $documentName => $uploadDocument) {
            $document = Document::create($companyId, $documentName);
            $this->repository->deleteBy($companyId, $documentName);
            $this->repository->save($document, $uploadDocument);
            $documents[] = $document->toArray();
        }

        $this->bus->publish(new DocumentCreatedDomainEvent($companyId, $documents));
    }
}