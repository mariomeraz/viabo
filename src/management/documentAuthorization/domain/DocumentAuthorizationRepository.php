<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\domain;

use Viabo\management\shared\domain\documents\DocumentId;
use Viabo\shared\domain\criteria\Criteria;

interface DocumentAuthorizationRepository
{
    public function save(DocumentAuthorized $authorized): void;

    public function search(DocumentId $documentId): array;

    public function searchCriteria(Criteria $criteria): array;

    public function searchProfileAuthorized(DocumentAuthorizationUserProfileId $userProfile): array;

}