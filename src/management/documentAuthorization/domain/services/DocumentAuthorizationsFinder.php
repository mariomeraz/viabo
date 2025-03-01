<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\domain\services;


use Viabo\management\documentAuthorization\domain\DocumentAuthorizationRepository;
use Viabo\management\shared\domain\documents\DocumentId;

final readonly class DocumentAuthorizationsFinder
{
    public function __construct(private DocumentAuthorizationRepository $repository)
    {
    }

    public function __invoke(DocumentId $documentId): array
    {
        return $this->repository->search($documentId);
    }


}