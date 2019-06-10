<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql;

use Doctrine\DBAL\Connections\MasterSlaveConnection;
use Radarlog\Doop\Infrastructure\Sql\Connection;
use Radarlog\Doop\Tests\FunctionalTestCase;

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
        self::assertSame('"images"', $this->connection->imagesTable());
    }
}
