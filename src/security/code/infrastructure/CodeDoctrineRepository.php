<?php declare(strict_types=1);


namespace Viabo\security\code\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\security\code\domain\Code;
use Viabo\security\code\domain\CodeRepository;
use Viabo\security\shared\domain\user\UserId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class CodeDoctrineRepository extends DoctrineRepository implements CodeRepository
{
    public function __construct(EntityManager $SecurityEntityManager)
    {
        parent::__construct($SecurityEntityManager);
    }

    public function save(Code $code): void
    {
        $this->persist($code);
    }

    public function search(string $userId): Code|null
    {
        return $this->repository(Code::class)->findOneBy(['userId' => $userId]);
    }

    public function searchCriteria(Criteria $criteria): Code|null
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        $result = $this->repository(Code::class)->matching($criteriaConvert)->toArray();
        return empty($result) ? null : $result[0];
    }

    public function delete(Code $code): void
    {
        $this->remove($code);
    }
}