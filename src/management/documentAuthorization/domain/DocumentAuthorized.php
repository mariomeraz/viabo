<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\domain;


use Viabo\management\shared\domain\documents\DocumentId;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class DocumentAuthorized extends AggregateRoot
{
    public function __construct(
        private DocumentAuthorizationId              $id ,
        private DocumentId                           $documentId ,
        private DocumentAuthorizationUserId          $userId ,
        private DocumentAuthorizationUserName        $userName ,
        private DocumentAuthorizationUserProfileId   $userProfileId ,
        private DocumentAuthorizationUserProfileName $userProfileName ,
        private DocumentAuthorizationRegister        $register
    )
    {
    }

    public static function empty(): static
    {
        return new static(
            DocumentAuthorizationId::random() ,
            DocumentId::random() ,
            new DocumentAuthorizationUserId('') ,
            new DocumentAuthorizationUserName('') ,
            new DocumentAuthorizationUserProfileId('') ,
            new DocumentAuthorizationUserProfileName('') ,
            new DocumentAuthorizationRegister('') ,
        );
    }

    public static function create(
        DocumentId                           $documentId ,
        DocumentAuthorizationUserId          $userId ,
        DocumentAuthorizationUserName        $userName ,
        DocumentAuthorizationUserProfileId   $userProfileId ,
        DocumentAuthorizationUserProfileName $userProfileName ,
    ): static
    {
        return new static(
            DocumentAuthorizationId::random() ,
            $documentId ,
            $userId ,
            $userName ,
            $userProfileId ,
            $userProfileName ,
            DocumentAuthorizationRegister::todayDate()
        );
    }

    public function userProfileData(): array
    {
        return [$this->userProfileId->value() , $this->userProfileName->value()];
    }

    public function documentId(): DocumentId
    {
        return $this->documentId;
    }

    public function userProfileId(): DocumentAuthorizationUserProfileId
    {
        return $this->userProfileId;
    }

    public function setEventNotificationToSET(): void
    {
        $this->record(new DocumentAuthorizationCreatedDomainEvent(
            $this->id->value(), $this->documentId->value()
        ));
    }
}