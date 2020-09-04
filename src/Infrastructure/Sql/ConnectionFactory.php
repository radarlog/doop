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
        if (!isset($params['slaves'], $params['master'])) {
            throw InvalidArgument::configuration();
        }

        $masterConnection = $this->dbalConnection($params['master']);

        $driver = $masterConnection->getDriver();

        $params = [
            'master' => $masterConnection->getParams(),
            'slaves' => $this->parseSlaves($params['slaves']),
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
    private function parseSlaves(string $slaves): array
    {
        $slaves = (array) preg_split('/[\n|,]/', $slaves);
        $slaves = array_filter($slaves);
        $slaves = array_unique($slaves);

        $parsed = [];

        while ($dsn = array_shift($slaves)) {
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
