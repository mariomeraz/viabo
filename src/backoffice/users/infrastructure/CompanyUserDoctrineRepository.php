<?php declare(strict_types=1);


namespace Viabo\backoffice\users\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\backoffice\company\domain\Company;
use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class CompanyUserDoctrineRepository extends DoctrineRepository implements CompanyUserRepository
{
    public function __construct(EntityManager $BackofficeEntityManager)
    {
        parent::__construct($BackofficeEntityManager);
    }

    public function save(CompanyUser $user): void
    {
        $this->persist($user);
    }

    public function search(string $companyId): Company|null
    {
        return $this->repository(Company::class)->find($companyId);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(CompanyUser::class)->matching($criteriaConvert)->toArray();
    }

    public function delete(CompanyUser $user): void
    {
        $this->remove($user);
    }

    public function update(CompanyUser $user): void
    {
        $this->entityManager()->flush($user);
    }
}
