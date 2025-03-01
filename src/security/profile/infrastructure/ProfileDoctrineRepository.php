<?php declare(strict_types=1);


namespace Viabo\security\profile\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\security\profile\domain\Profile;
use Viabo\security\profile\domain\ProfileRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class ProfileDoctrineRepository extends DoctrineRepository implements ProfileRepository
{
    public function __construct(EntityManager $SecurityEntityManager)
    {
        parent::__construct($SecurityEntityManager);
    }

    public function search(string $profileId): Profile|null
    {
        return $this->repository(Profile::class)->find($profileId);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Profile::class)->matching($criteriaConvert)->toArray();
    }
}