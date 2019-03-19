<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests;

use Radarlog\S3Uploader\Infrastructure\MySql\Connection;

class DbTestCase extends FunctionalTestCase
{
    /** @var Connection */
    private $connection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = self::$container->get(Connection::class);

        $this->connection->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->connection->rollBack();

        parent::tearDown();
    }
}
