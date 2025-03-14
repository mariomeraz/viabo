<?php declare(strict_types=1);

namespace Viabo\Tests\shared\infrastructure\doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use function Lambdish\Phunctional\first;
use function Lambdish\Phunctional\map;

final class MySqlDatabaseCleaner
{
    public function __invoke(EntityManagerInterface $entityManager): void
    {
        $connection = $entityManager->getConnection();

        $tables            = $this->tables($connection);
        $truncateTablesSql = $this->truncateDatabaseSql($tables);

        $connection->exec($truncateTablesSql);
    }

    private function truncateDatabaseSql(array $tables): string
    {
        $truncateTables = map($this->truncateTableSql(), $tables);

        return sprintf('SET FOREIGN_KEY_CHECKS = 0; %s SET FOREIGN_KEY_CHECKS = 1;', implode(' ', $truncateTables));
    }

    private function truncateTableSql(): callable
    {
        return fn(array $table): string => sprintf('TRUNCATE TABLE `%s`;', first($table));
    }

    private function tables(Connection $connection): array
    {
        $tables = $connection->query('SHOW TABLES')->fetchAll();
        return array_filter($tables , function (array $table) {
            return strpos(first($table) , 'v_');
        });
    }
}