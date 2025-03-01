<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\domain;


use Viabo\management\shared\domain\documents\DocumentId;

final class DocumentAuthorization
{

    private DocumentAuthorized $documentAuthorized;

    public function __construct()
    {
        $this->documentAuthorized = DocumentAuthorized::empty();
    }


    public static function createAuthorized(
        DocumentId                         $documentId ,
        DocumentAuthorizationUserId        $userId ,
        DocumentAuthorizationUserName      $userName ,
        DocumentAuthorizationUserProfileId $userProfileId ,
        DocumentAuthorizationUserProfileName $userProfileName
    ): static
    {
        $documentAuthorization = new self();
        $documentAuthorization->documentAuthorized = DocumentAuthorized::create(
            $documentId , $userId , $userName , $userProfileId , $userProfileName
        );

        return $documentAuthorization;
    }

    public function userProfileData(): array
    {
        return $this->documentAuthorized->userProfileData();
    }

    public function authorized(): DocumentAuthorized
    {
        return $this->documentAuthorized;
    }

    public function documentId(): DocumentId
    {
        return $this->documentAuthorized->documentId();
    }

    public function userProfile(): DocumentAuthorizationUserProfileId
    {
        return $this->documentAuthorized->userProfileId();
    }

    public function setEventNotificationToProfileSET(): void
    {
        $this->documentAuthorized->setEventNotificationToSET();
    }

}