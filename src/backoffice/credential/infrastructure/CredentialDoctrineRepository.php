<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\backoffice\credential\domain\Credential;
use Viabo\backoffice\credential\domain\CredentialRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class CredentialDoctrineRepository extends DoctrineRepository implements CredentialRepository
{
    public function __construct(EntityManager $BackofficeEntityManager)
    {
        parent::__construct($BackofficeEntityManager);
    }

    public function save(Credential $credential): void
    {
        $this->persist($credential);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Credential::class)->matching($criteriaConvert)->toArray();
    }
}