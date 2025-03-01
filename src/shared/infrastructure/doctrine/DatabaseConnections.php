<?php declare(strict_types=1);

namespace Viabo\shared\infrastructure\doctrine;

use Doctrine\ORM\EntityManager;
use Viabo\shared\domain\utils;
use Viabo\Tests\shared\infrastructure\doctrine\MySqlDatabaseCleaner;
use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\each;

final class DatabaseConnections
{
    private array $connections;

    public function __construct(iterable $connections)
    {
        $this->connections = Utils::iterableToArray($connections);
    }

    public function clear(): void
    {
        each(fn(EntityManager $entityManager) => $entityManager->clear(), $this->connections);
    }

    public function truncate(): void
    {
        apply(new MySqlDatabaseCleaner(), array_values($this->connections));
    }

    public function clearRecords(array $records): void
    {
        each(function (EntityManager $entityManager) use ($records) {
            foreach ($records as $record) {
                $clause = "{$record['field']} {$record['operator']} '{$record['value']}'";
                $query = "DELETE FROM {$record['table']} WHERE $clause";
                $entityManager->getConnection()->executeQuery($query);
            }
        }, $this->connections);
    }

    public function updateRecords(array $records, array $where): void
    {
        each(function (EntityManager $entityManager) use ($records, $where) {
            foreach ($records as $record) {
                $clause = "{$record['field']} {$record['operator']} '{$record['value']}'";
                $filter = "{$where['field']} {$where['operator']} '{$where['value']}'";
                $query = "UPDATE {$record['table']} SET $clause WHERE $filter";
                $entityManager->getConnection()->executeQuery($query);
            }
        }, $this->connections);
    }
}
