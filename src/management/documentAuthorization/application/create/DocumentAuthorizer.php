<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\application\create;


use Viabo\management\documentAuthorization\domain\DocumentAuthorization;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationRepository;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserId;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserName;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserProfileId;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserProfileName;
use Viabo\management\documentAuthorization\domain\services\DocumentAuthorizationValidator;
use Viabo\management\shared\domain\documents\DocumentId;
use Viabo\backoffice\documents\application\find\FindDocumentQuery;
use Viabo\backoffice\documents\application\find\FindDocumentsCommerceQuery;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class DocumentAuthorizer
{
    public function __construct(
        private DocumentAuthorizationRepository $repository ,
        private QueryBus                        $queryBus ,
        private DocumentAuthorizationValidator  $authorizationValidator ,
    )
    {
    }

    public function __invoke(
        DocumentId                           $documentId ,
        DocumentAuthorizationUserId          $userId ,
        DocumentAuthorizationUserName        $userName ,
        DocumentAuthorizationUserProfileId   $userProfileId ,
        DocumentAuthorizationUserProfileName $userProfileName
    ): void
    {
        $commerceId = $this->getCommerceIdOf($documentId);
        $documentsCommerce = $this->getAllDocumentsOf($commerceId);


        $documentAuthorization = DocumentAuthorization::createAuthorized(
            $documentId , $userId , $userName , $userProfileId , $userProfileName
        );

        $this->authorizationValidator->hasValidationPermission($documentAuthorization->userProfile());
        $this->authorizationValidator->alreadyExists($documentAuthorization);

        //Queda pendiente la validacion para enviar la notificacion
//        if ($this->authorizationValidator->hasTwoAuthorizationsAllDocuments($documentAuthorization)) {
//            $documentAuthorization->setEventNotificationToProfileSET();
//        }

//        $this->repository->save($documentAuthorization->authorized());
    }

    private function getCommerceIdOf(DocumentId $documentId): string
    {
        $documentData = $this->queryBus->ask(new FindDocumentQuery($documentId->value()));
        return $documentData->documentData['commerceId'];
    }

    private function getAllDocumentsOf(string $commerceId): array
    {
        $data = $this->queryBus->ask(new FindDocumentsCommerceQuery($commerceId));
        return array_map(function (array $document) {
            return $document['id'];
        } , $data->documents);
    }

}