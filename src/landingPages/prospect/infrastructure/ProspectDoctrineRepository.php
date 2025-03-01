<?php declare(strict_types=1);


namespace Viabo\landingPages\prospect\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\landingPages\prospect\domain\Prospect;
use Viabo\landingPages\prospect\domain\ProspectRepository;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class ProspectDoctrineRepository extends DoctrineRepository implements ProspectRepository
{
    public function __construct(EntityManager $LandingPagesEntityManager)
    {
        parent::__construct($LandingPagesEntityManager);
    }

    public function save(Prospect $prospect): void
    {
        $this->persist($prospect);
    }

    public function searchEmail(string $email): Prospect|null
    {
        return $this->repository(Prospect::class)->findOneBy(['email.value' => $email]);
    }
}