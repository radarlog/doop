<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql\Read;

use Doctrine\DBAL\Driver\Statement;
use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Infrastructure\Sql;

final class FindHashCountImage implements Query\Image\FindHashCount
{
    private Sql\Connection $connection;

    public function __construct(Sql\Connection $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): Query\Image\HashCount
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('i1.hash as hash, COUNT(i1.*) as count')
            ->from($this->connection->imagesTable(), 'i1')
            ->innerJoin('i1', $this->connection->imagesTable(), 'i2', 'i1.hash = i2.hash')
            ->where(
                $qb->expr()->eq('i1.uuid', $qb->createNamedParameter($id)),
            )
            ->groupBy('i1.hash');

        /** @var Statement $stmt */
        $stmt = $qb->execute();

        if ($stmt->rowCount() === 0) {
            throw Sql\NotFound::uuid($id);
        }

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return new Query\Image\HashCount($row['hash'], $row['count']);
    }
}
