<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\domain;


use Viabo\backoffice\shared\domain\documents\DocumentId;
use Viabo\shared\domain\criteria\Criteria;

interface DocumentRepository
{
    public function save(Document $document, $uploadDocument): void;

    public function search(DocumentId $documentId): Document|null;

    public function searchCriteria(Criteria $criteria): array;

    public function deleteBy(string $companyId, string $name): void;

    public function delete(Document $document): void;
}