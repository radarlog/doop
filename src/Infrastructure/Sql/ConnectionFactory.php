<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Doctrine\DBAL;

final class ConnectionFactory
{
    private readonly Connection $connection;

    private function __construct(string $primaryDsn, string $replicaDsn)
    {
        /** @var Connection $connection */
        $connection = DBAL\DriverManager::getConnection([
            'driverClass' => DBAL\Driver\PDO\PgSQL\Driver::class,
            'driverOptions' => [
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ],
            'primary' => ['url' => $primaryDsn],
            'replica' => $this->parseReplicas($replicaDsn),
            'wrapperClass' => Connection::class,
        ]);

        $this->connection = $connection;
    }

    public static function create(string $primaryDsn, string $replicaDsn): Connection
    {
        $factory = new self($primaryDsn, $replicaDsn);

        return $factory->connection;
    }

    /**
     * @return array<int, array{url: string}>
     */
    private function parseReplicas(string $replicasDsn): array
    {
        $replicas = (array) preg_split('/[\n|,]/', $replicasDsn);
        $replicas = array_filter($replicas);
        $replicas = array_unique($replicas);

        return array_map(
            static fn(string $replicaDsn) => ['url' => $replicaDsn],
            $replicas,
        );
    }
}
