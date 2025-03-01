<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\backoffice\costCenter\domain\CostCenter;
use Viabo\backoffice\costCenter\domain\CostCenterCompany;
use Viabo\backoffice\costCenter\domain\CostCenterRepository;
use Viabo\backoffice\costCenter\domain\CostCenterUser;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class CostCenterDoctrineRepository extends DoctrineRepository implements CostCenterRepository
{
    public function __construct(EntityManager $BackofficeEntityManager)
    {
        parent::__construct($BackofficeEntityManager);
    }

    public function save(CostCenter $costCenter): void
    {
        $this->persist($costCenter);
    }

    public function search(string $costCenterId): CostCenter|null
    {
        $costCenter = $this->repository(CostCenter::class)->find($costCenterId);
        $this->searchCompanies($costCenter);
        return $costCenter;
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(CostCenter::class)->matching($criteriaConvert)->toArray();
    }

    public function searchAll(string $businessId): array
    {
        $costCenters = $this->repository(CostCenter::class)->findBy([
            'businessId.value' => $businessId,
            'active.value' => '1'
        ]);
        array_map(function (CostCenter $costCenter) {
            $this->searchCompanies($costCenter);
        }, $costCenters);
        return $costCenters;
    }

    public function searchUser(string $userId): CostCenterUser|null
    {
        return $this->repository(CostCenterUser::class)->find($userId);
    }

    public function searchByAdminUser(string $userId): array
    {
        $dql = "SELECT c FROM Viabo\backoffice\costCenter\domain\CostCenter c 
                JOIN c.users u 
                WHERE u.id = ?1";

        return $this->entityManager()->createQuery($dql)
            ->setParameter(1, $userId)
            ->getResult();
    }

    public function searchFolioLast(): CostCenter|null
    {
        return $this->repository(CostCenter::class)->findOneBy([], ['folio.value' => 'desc']);
    }

    public function update(CostCenter $costCenter): void
    {
        $this->entityManager()->flush($costCenter);
        $this->updateCompanies($costCenter);
    }

    public function delete(CostCenter $costCenter): void
    {
        $this->remove($costCenter);
    }

    private function searchCompanies(CostCenter|null $costCenter): void
    {
        if (!empty($costCenter)) {
            $query = "select CompanyId from t_backoffice_companies_and_cost_centers where CostCenterId = :costcenterId";
            $statement = $this->entityManager()->getConnection()->prepare($query);
            $statement->bindValue('costcenterId', $costCenter->id());
            $companies = $statement->executeQuery()->fetchAllAssociative();
            $costCenter->setCompanies($companies);
        }
    }

    private function updateCompanies(CostCenter $costCenter): void
    {
        $costCenterId = $costCenter->id();
        array_map(function (CostCenterCompany $company) use ($costCenterId) {
            $this->insertCostCenterCompany($company->id(), $costCenterId);
        }, $costCenter->companies());
    }

    public function deleteCostCenterCompanies(string $companyId): void
    {
        $query = "delete from t_backoffice_companies_and_cost_centers where CompanyId = :companyId";
        $statement = $this->entityManager()->getConnection()->prepare($query);
        $statement->bindValue('companyId', $companyId);
        $statement->executeQuery()->fetchAllAssociative();
    }

    private function insertCostCenterCompany(string $companyId, string $costCenterId): void
    {
        $query = "insert into t_backoffice_companies_and_cost_centers (CompanyId,CostCenterId)
            values (:companyId,:costcenterId)";
        $statement = $this->entityManager()->getConnection()->prepare($query);
        $statement->bindValue('companyId', $companyId);
        $statement->bindValue('costcenterId', $costCenterId);
        $statement->executeQuery()->fetchAllAssociative();
    }
}