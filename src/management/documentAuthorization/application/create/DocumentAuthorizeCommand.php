<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class DocumentAuthorizeCommand implements Command
{
    public function __construct(
        public string $documentId ,
        public string $userId ,
        public string $userName ,
        public string $userProfileId,
        public string $userProfileName
    )
    {
    }
}