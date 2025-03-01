<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\infrastructure;

use Doctrine\ORM\EntityManager;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidation;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class TerminalConsolidationDoctrineRepository extends DoctrineRepository implements TerminalConsolidationRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(TerminalConsolidation $terminalConsolidation): void
    {
        $this->persist($terminalConsolidation);
    }

    public function searchCriteria(Criteria $criteria):array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(TerminalConsolidation::class)->matching($criteriaConvert)->toArray();
    }
}
