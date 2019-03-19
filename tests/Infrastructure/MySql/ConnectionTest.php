<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\MySql;

use Doctrine\DBAL\Connections\MasterSlaveConnection;
use Radarlog\S3Uploader\Infrastructure\MySql\Connection;
use Radarlog\S3Uploader\Tests\FunctionalTestCase;

class ConnectionTest extends FunctionalTestCase
{
    /** @var Connection */
    private $connection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = self::$container->get(Connection::class);
    }

    public function testIsMasterSlave(): void
    {
        self::assertInstanceOf(MasterSlaveConnection::class, $this->connection);
    }

    public function testImportResultsTable(): void
    {
        self::assertSame('images', $this->connection->imagesTable());
    }
}
