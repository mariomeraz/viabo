<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationRepository;
use Viabo\management\documentAuthorization\domain\DocumentAuthorizationUserProfileId;
use Viabo\management\documentAuthorization\domain\DocumentAuthorized;
use Viabo\management\shared\domain\documents\DocumentId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class DocumentAuthorizationDoctrineRepository extends DoctrineRepository implements DocumentAuthorizationRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(DocumentAuthorized $authorized): void
    {
        $this->persist($authorized);
    }

    public function search(DocumentId $documentId): array
    {
        return $this->repository(DocumentAuthorized::class)->findBy(['documentId' => $documentId->value()]);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(DocumentAuthorized::class)->matching($criteriaConvert)->toArray();
    }

    public function searchProfileAuthorized(DocumentAuthorizationUserProfileId $userProfile): array
    {
        $query = "select * from t_management_commerces_document_profiles_to_autorize where UserProfileId = :profileId";
        $statement = $this->entityManager()->getConnection()->prepare($query);
        $statement->bindValue('profileId' , $userProfile->value());
        return $statement->executeQuery()->fetchAllAssociative();
    }
}