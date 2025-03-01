<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\domain\services;


use Viabo\management\documentAuthorization\domain\DocumentAuthorization;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationRepository;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserProfileId;
use Viabo\management\documentAuthorization\domain\exceptions\DocumentAuthorizationExist;
use Viabo\management\documentAuthorization\domain\exceptions\DocumentAuthorizationNotAuthorized;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class DocumentAuthorizationValidator
{

    public function __construct(private DocumentAuthorizationRepository $repository)
    {
    }

    public function hasValidationPermission(DocumentAuthorizationUserProfileId $userProfile): void
    {
        $profileAuthorized = $this->repository->searchProfileAuthorized($userProfile);
        if (empty($profileAuthorized)) {
            throw new DocumentAuthorizationNotAuthorized();
        }
    }

    public function alreadyExists(DocumentAuthorization $documentAuthorization): void
    {
        list($profileId , $profileName) = $documentAuthorization->userProfileData();
        $documentId = $documentAuthorization->documentId()->value();
        $filters = Filters::fromValues([
            ['field' => 'documentId' , 'operator' => '=' , 'value' => $documentId] ,
            ['field' => 'userProfileId.value' , 'operator' => '=' , 'value' => $profileId]
        ]);

        $authorization = $this->repository->searchCriteria(new Criteria($filters));

        if (!empty($authorization)) {
            throw new DocumentAuthorizationExist($profileName);
        }
    }

    public function hasTwoAuthorizationsAllDocuments(DocumentAuthorization $documentAuthorization): bool
    {
        $authorizations = $this->repository->search($documentAuthorization->documentId());

        return count($authorizations) > 2;
    }


}