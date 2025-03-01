<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\backoffice\commission\domain\card\CommissionCard;
use Viabo\backoffice\commission\domain\Commission;
use Viabo\backoffice\commission\domain\CommissionRepository;
use Viabo\backoffice\commission\domain\spei\CommissionSpei;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class CommissionDoctrineRepository extends DoctrineRepository implements CommissionRepository
{
    public function __construct(EntityManager $BackofficeEntityManager)
    {
        parent::__construct($BackofficeEntityManager);
    }

    public function save(Commission $commission): void
    {
        $this->persist($commission);
    }

    public function search(string $companyId): Commission|null
    {
        return $this->repository(Commission::class)->findOneBy(['companyId' => $companyId]);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Commission::class)->matching($criteriaConvert)->toArray();
    }

    public function update(Commission $commission): void
    {
        $this->entityManager()->flush($commission);
    }

    public function delete(Commission $commission): void
    {
        $this->remove($commission);
        $table = '';
        if ($commission instanceof CommissionSpei) {
            $table = 't_backoffice_companies_commission_spei';
        }

        if ($commission instanceof CommissionCard) {
            $table = 't_backoffice_companies_commission_card';
        }

        $query = "DELETE FROM $table WHERE Id = :id";
        $statement = $this->entityManager()->getConnection()->prepare($query);
        $statement->bindValue('id', $commission->id());
        $statement->execute();
    }
}