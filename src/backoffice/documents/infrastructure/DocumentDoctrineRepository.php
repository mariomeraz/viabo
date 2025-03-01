<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\infrastructure;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Viabo\backoffice\documents\domain\Document;
use Viabo\backoffice\documents\domain\DocumentRepository;
use Viabo\backoffice\shared\domain\documents\DocumentId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;
use Viabo\shared\infrastructure\symfony\uploadFile\UploadedFileSymfonyAdapter;

final class DocumentDoctrineRepository extends DoctrineRepository implements DocumentRepository
{
    public function __construct(
        EntityManager                               $BackofficeEntityManager,
        private readonly UploadedFileSymfonyAdapter $uploadedFile
    )
    {
        parent::__construct($BackofficeEntityManager);
    }


    public function save(Document $document, $uploadDocument): void
    {
        if ($uploadDocument instanceof UploadedFile) {
            $this->uploadedFile->upload(
                $uploadDocument,
                $document->directoryPath(),
                ['pdf', 'img', 'jpg', 'png'],
                $document->name()->value()
            );
            $document->recordUploadFileData($this->uploadedFile->path(), $this->uploadedFile->fileName());
        } else {
            $document->recordUploadFileData($uploadDocument);
        }
        $this->persist($document);
    }

    public function search(DocumentId $documentId): Document|null
    {
        return $this->repository(Document::class)->find($documentId->value());
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaDoctrine = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Document::class)->matching($criteriaDoctrine)->toArray();
    }

    public function deleteBy(string $companyId, string $name): void
    {
        $this->entityManager()->getConnection()->delete('t_backoffice_companies_documents',
            ['CompanyId' => $companyId, 'Name' => $name]
        );
    }

    public function delete(Document $document): void
    {
        $this->uploadedFile->removeFile($document->directoryFilePath());
        $this->remove($document);
    }
}