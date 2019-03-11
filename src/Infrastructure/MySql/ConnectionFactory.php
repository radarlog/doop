<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\MySql;

use Doctrine\DBAL;

final class ConnectionFactory
{
    /** @var Connection */
    private $connection;

    private function __construct(array $params)
    {
        if (!isset($params['slaves'], $params['master'])) {
            throw new InvalidArgument('Master or slaves configuration is missing', InvalidArgument::CODE_MYSQL_SEVERS);
        }

        $masterConnection = $this->dbalConnection($params['master']);

        $driver = $masterConnection->getDriver();

        $params = [
            'master' => $masterConnection->getParams(),
            'slaves' => $this->parseSlaves($params['slaves']),
            'driver' => $driver->getName(),
        ];

        $this->connection = new Connection($params, $driver);
    }

    public static function create(array $params): Connection
    {
        $factory = new self($params);

        return $factory->connection;
    }

    private function parseSlaves(string $slaves): array
    {
        $slaves = preg_split('/[\n|,]/', $slaves);
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
        return DBAL\DriverManager::getConnection(['url' => $dsn]);
    }
}
