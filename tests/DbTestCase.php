<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests;

use Radarlog\Doop\Infrastructure\Sql\Connection;

abstract class DbTestCase extends FunctionalTestCase
{
    readonly private Connection $connection;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Connection $connection */
        $connection = self::getContainer()->get(Connection::class);

        $connection->beginTransaction();

        $this->connection = $connection;
    }

    protected function tearDown(): void
    {
        $this->connection->rollBack();

        parent::tearDown();
    }
}
