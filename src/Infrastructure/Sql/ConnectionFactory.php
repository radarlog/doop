<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Doctrine\DBAL;

final class ConnectionFactory
{
    private Connection $connection;

    /**
     * @param string[] $params
     *
     * @throws InvalidArgument
     * @throws \InvalidArgumentException
     */
    private function __construct(array $params)
    {
        if (!isset($params['replica'], $params['primary'])) {
            throw InvalidArgument::configuration();
        }

        $masterConnection = $this->dbalConnection($params['primary']);

        $driver = $masterConnection->getDriver();

        $params = [
            'primary' => $masterConnection->getParams(),
            'replica' => $this->parseReplicas($params['replica']),
            'driver' => $driver,
            'driverOptions' => [
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ],
        ];

        $this->connection = new Connection($params, $driver);
    }

    /**
     * @param string[] $params
     *
     * @throws InvalidArgument
     * @throws \InvalidArgumentException
     */
    public static function create(array $params): Connection
    {
        $factory = new self($params);

        return $factory->connection;
    }

    /**
     * @return string[][]
     */
    private function parseReplicas(string $replicas): array
    {
        $replicas = (array) preg_split('/[\n|,]/', $replicas);
        $replicas = array_filter($replicas);
        $replicas = array_unique($replicas);

        $parsed = [];

        while ($dsn = array_shift($replicas)) {
            $parsed[] = $this->dbalConnection($dsn)->getParams();
        }

        return $parsed;
    }

    private function dbalConnection(string $dsn): DBAL\Connection
    {
        // https://github.com/doctrine/dbal/commit/487b00fbcb2a607bd12bb78fbc27739216ec4626
        // @phpstan-ignore-next-line
        return DBAL\DriverManager::getConnection(['url' => $dsn]);
    }
}
