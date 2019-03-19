<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\MySql;

use Radarlog\S3Uploader\Infrastructure\MySql;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class ConnectionFactoryTest extends UnitTestCase
{
    public function invalidParamsProvider(): \Generator
    {
        yield [[['master' => 'some_dsn']]];
        yield [[['slaves' => 'some_dsn']]];
    }

    /**
     * @dataProvider invalidParamsProvider
     */
    public function testCreateFromInvalidParamsThrowsException(array $params): void
    {
        $this->expectException(MySql\InvalidArgument::class);
        $this->expectExceptionCode(MySql\InvalidArgument::CODE_MYSQL_SEVERS);

        MySql\ConnectionFactory::create($params);
    }

    public function slaveDelimitersProvider(): \Generator
    {
        yield ["\n"];
        yield [','];
        yield ['|'];
    }

    /**
     * @dataProvider slaveDelimitersProvider
     */
    public function testCreateTwoSlaves(string $delimiter): void
    {
        $params = [
            'master' => 'mysql://user:user@host:3306/db',
            'slaves' => sprintf('mysql://user:user@host:3306/db1%smysql://user:user@host:3306/db2', $delimiter),
        ];

        $connection = MySql\ConnectionFactory::create($params);

        self::assertCount(2, $connection->getParams()['slaves']);
    }
}
