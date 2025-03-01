<?php declare(strict_types=1);


namespace Viabo\security\userLog\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\security\userLog\domain\UserLog;
use Viabo\security\userLog\domain\UserLogRepository;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class UserLogDoctrineRepository extends DoctrineRepository implements UserLogRepository
{
    public function __construct(EntityManager $SecurityEntityManager)
    {
        parent::__construct($SecurityEntityManager);
    }

    public function save(UserLog $log): void
    {
        $this->persist($log);
    }
}