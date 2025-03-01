<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\application\delete;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class DeleteDocumentsCommandHandler implements CommandHandler
{
    public function __construct(private DocumentsDeleter $deleter)
    {
    }

    public function __invoke(DeleteDocumentsCommand $command): void
    {
        $this->deleter->__invoke($command->commerceId, $command->uploadDocuments);
    }
}