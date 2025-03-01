<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\application\create_documents_by_register_company;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateDocumentsCommandHandlerByRegisterCompany implements CommandHandler
{
    public function __construct(private DocumentsCreatorByRegisterCompany $creator)
    {
    }

    public function __invoke(CreateDocumentsCommandByRegisterCompany $command): void
    {
        $this->creator->__invoke($command->companyId, $command->uploadDocuments);
    }
}