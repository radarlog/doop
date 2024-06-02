<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql;

use PHPUnit\Framework\Attributes\DataProvider;
use Radarlog\Doop\Infrastructure\Sql;
use Radarlog\Doop\Tests\UnitTestCase;

final class ConnectionFactoryTest extends UnitTestCase
{
    /**
     * @return iterable<array<int,string>>
     */
    public static function replicaDelimitersProvider(): iterable
    {
        yield ["\n"];
        yield [','];
        yield ['|'];
    }

    /**
     * @psalm-suppress InternalMethod
     */
    #[DataProvider('replicaDelimitersProvider')]
    public function testCreateTwoReplicas(string $delimiter): void
    {
        $primaryDsn = 'pgsql://user:user@host:3306/db';
        $replicaDsn = sprintf('pgsql://user:user@host:3306/db1%spgsql://user:user@host:3306/db2', $delimiter);

        $connection = Sql\ConnectionFactory::create($primaryDsn, $replicaDsn);

        /** @var array{replica: string[]} $params */
        $params = $connection->getParams();

        self::assertCount(2, $params['replica']);
    }
}
