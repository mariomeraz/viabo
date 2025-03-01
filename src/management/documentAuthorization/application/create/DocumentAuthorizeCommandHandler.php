<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\application\create;


use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserId;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserName;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserProfileId;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserProfileName;
use Viabo\management\shared\domain\documents\DocumentId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class DocumentAuthorizeCommandHandler implements CommandHandler
{
    public function __construct(private DocumentAuthorizer $authorizer)
    {
    }

    public function __invoke(DocumentAuthorizeCommand $command): void
    {
        $documentId = new DocumentId($command->documentId);
        $userId = new DocumentAuthorizationUserId($command->userId);
        $userName = new DocumentAuthorizationUserName($command->userName);
        $userProfileId = new DocumentAuthorizationUserProfileId($command->userProfileId);
        $userProfileName = new DocumentAuthorizationUserProfileName($command->userProfileName);

        $this->authorizer->__invoke($documentId , $userId , $userName , $userProfileId , $userProfileName);
    }
}