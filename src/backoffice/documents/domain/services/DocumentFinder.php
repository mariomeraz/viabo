<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\domain\services;


use Viabo\management\documentAuthorization\domain\exceptions\DocumentNotExist;
use Viabo\backoffice\documents\domain\Document;
use Viabo\backoffice\documents\domain\DocumentRepository;
use Viabo\backoffice\shared\domain\documents\DocumentId;

final readonly class DocumentFinder
{
    public function __construct(private DocumentRepository $repository)
    {
    }

    public function __invoke(DocumentId $documentId): Document
    {
        $document = $this->repository->search($documentId);

        if (empty($document)) {
            throw new DocumentNotExist();
        }

        return $document;
    }

}