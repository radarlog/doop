<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql;

use Radarlog\Doop\Infrastructure\Sql;
use Radarlog\Doop\Tests\UnitTestCase;

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
        $this->expectException(Sql\InvalidArgument::class);
        $this->expectExceptionCode(3000);

        Sql\ConnectionFactory::create($params);
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
            'master' => 'pgsql://user:user@host:3306/db',
            'slaves' => sprintf('pgsql://user:user@host:3306/db1%spgsql://user:user@host:3306/db2', $delimiter),
        ];

        $connection = Sql\ConnectionFactory::create($params);

        self::assertCount(2, $connection->getParams()['slaves']);
    }
}
