<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\security\authenticatorFactor\domain\AuthenticatorFactor;
use Viabo\security\authenticatorFactor\domain\AuthenticatorFactorRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class AuthenticatorFactorDoctrineRepository extends DoctrineRepository implements AuthenticatorFactorRepository
{
    public function __construct(EntityManager $SecurityEntityManager)
    {
        parent::__construct($SecurityEntityManager);
    }

    public function save(AuthenticatorFactor $authenticator): void
    {
        $this->persist($authenticator);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(AuthenticatorFactor::class)->matching($criteriaConvert)->toArray();
    }
}