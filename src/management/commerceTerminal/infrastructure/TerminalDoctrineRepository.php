<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\infrastructure;

use Doctrine\ORM\EntityManager;
use Viabo\management\commerceTerminal\domain\Terminal;
use Viabo\management\commerceTerminal\domain\TerminalRepository;
use Viabo\management\commerceTerminal\domain\TerminalShared;
use Viabo\management\commerceTerminal\domain\TerminalView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class TerminalDoctrineRepository extends DoctrineRepository implements TerminalRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(Terminal $terminal): void
    {
        $this->persist($terminal);
    }

    public function search(string $terminalId): Terminal|null
    {
        return $this->repository(Terminal::class)->find($terminalId);
    }

    public function searchView(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(TerminalView::class)->matching($criteriaConvert)->toArray();
    }

    public function searchTerminalsShared(string $commerceId): array
    {
        return $this->repository(TerminalShared::class)->findBy(['commerceId' => $commerceId]);
    }
}
