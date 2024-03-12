<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Doctrine\DBAL;

/**
 * @psalm-import-type Params from DBAL\DriverManager
 */
final readonly class ConnectionFactory
{
    private Connection $connection;

    private function __construct(string $primaryDsn, string $replicasDsn)
    {
        $dsnParser = new DBAL\Tools\DsnParser();

        /** @var Params $params */
        $params = [
            'driverClass' => DBAL\Driver\PDO\PgSQL\Driver::class,
            'driverOptions' => [
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ],
            'primary' => $dsnParser->parse($primaryDsn),
            'replica' => array_map(
                static fn(string $replicaDsn) => $dsnParser->parse($replicaDsn),
                $this->findReplicas($replicasDsn),
            ),
            'wrapperClass' => Connection::class,
        ];

        /** @var Connection $connection */
        $connection = DBAL\DriverManager::getConnection($params);

        $this->connection = $connection;
    }

    public static function create(string $primaryDsn, string $replicaDsn): Connection
    {
        $factory = new self($primaryDsn, $replicaDsn);

        return $factory->connection;
    }

    /**
     * @return string[]
     */
    private function findReplicas(string $replicasDsn): array
    {
        $replicas = (array) preg_split('/[\n|,]/', $replicasDsn);
        $replicas = array_filter($replicas);

        return array_unique($replicas);
    }
}
