<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests;

use Radarlog\Doop\Infrastructure\Sql\Connection;

abstract class DbTestCase extends FunctionalTestCase
{
    private Connection $connection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = self::getContainer()->get(Connection::class);

        $this->connection->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->connection->rollBack();

        parent::tearDown();
    }
}
