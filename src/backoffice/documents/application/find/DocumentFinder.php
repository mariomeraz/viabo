<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\application\find;


use Viabo\backoffice\documents\domain\services\DocumentFinder as DocumentFinderService;
use Viabo\backoffice\shared\domain\documents\DocumentId;

final readonly class DocumentFinder
{
    public function __construct(private DocumentFinderService $finder)
    {
    }

    public function __invoke(DocumentId $documentId): DocumentResponse
    {
        $document = $this->finder->__invoke($documentId);

        return new DocumentResponse($document->toArray());
    }


}