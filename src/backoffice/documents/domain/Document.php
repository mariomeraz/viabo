<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\domain;


use Viabo\backoffice\documents\domain\events\DocumentDeletedDomainEvent;
use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\backoffice\shared\domain\documents\DocumentId;
use Viabo\shared\domain\aggregate\AggregateRoot;

final  class Document extends AggregateRoot
{
    public function __construct(
        private DocumentId        $id,
        private CompanyId         $companyId,
        private DocumentName      $name,
        private DocumentStorePath $storePath,
        private DocumentRegister  $register
    )
    {
    }

    public static function create(string $companyId, string $name): Document
    {
        return new self(
            DocumentId::random(),
            CompanyId::create($companyId),
            DocumentName::create($name),
            DocumentStorePath::empty(),
            DocumentRegister::todayDate()
        );
    }

    public function name(): DocumentName
    {
        return $this->name;
    }

    public function directoryFilePath(): string
    {
        return $this->storePath->directory();
    }

    public function directoryPath(): string
    {
        return "/Business/Commerce_{$this->companyId->value()}/Documents";
    }

    public function recordUploadFileData(string $path, string $fileName = '' ): void
    {
        $this->name = $this->name->update($fileName);
        $this->storePath = $this->storePath->update($path);
    }

    public function setEventDelete(): void
    {
        $this->record(new DocumentDeletedDomainEvent($this->id->value(), $this->toArray()));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'commerceId' => $this->companyId->value(),
            'name' => $this->name->value(),
            'storePath' => $this->storePath->value(),
            'register' => $this->register->value()
        ];
    }
}