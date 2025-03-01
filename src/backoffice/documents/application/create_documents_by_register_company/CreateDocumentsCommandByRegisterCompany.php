<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\application\create_documents_by_register_company;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateDocumentsCommandByRegisterCompany implements Command
{
    public function __construct(public string $companyId , public array $uploadDocuments)
    {
    }
}