<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql;

use Radarlog\Doop\Infrastructure\Sql;
use Radarlog\Doop\Tests\UnitTestCase;

class ConnectionFactoryTest extends UnitTestCase
{
    public function invalidParamsProvider(): \Generator
    {
        yield [[['primary' => 'some_dsn']]];
        yield [[['replica' => 'some_dsn']]];
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

    public function replicaDelimitersProvider(): \Generator
    {
        yield ["\n"];
        yield [','];
        yield ['|'];
    }

    /**
     * @dataProvider replicaDelimitersProvider
     */
    public function testCreateTwoReplicas(string $delimiter): void
    {
        $params = [
            'primary' => 'pgsql://user:user@host:3306/db',
            'replica' => sprintf('pgsql://user:user@host:3306/db1%spgsql://user:user@host:3306/db2', $delimiter),
        ];

        $connection = Sql\ConnectionFactory::create($params);

        self::assertCount(2, $connection->getParams()['replica']);
    }
}
