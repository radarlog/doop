<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Doctrine\DBAL\Driver\Statement;
use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Infrastructure\Sql;

final class ReadModel implements Query
{
    private Sql\Connection $connection;

    public function __construct(Sql\Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findAllSortedByUploadDate(): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select(['uuid, name, uploaded_at'])
            ->from($this->connection->imagesTable())
            ->orderBy('uploaded_at', 'DESC');

        return $this->connection->project(
            $qb->getSQL(),
            $qb->getParameters(),
            static fn(array $row) => new Query\UuidNameDate(
                $row['uuid'],
                $row['name'],
                $row['uploaded_at'],
            ),
        );
    }

    public function findOneHashNameById(string $id): Query\HashName
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select(['hash', 'name'])
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($id)),
            );

        /** @var Statement $stmt */
        $stmt = $qb->execute();

        if ($stmt->rowCount() === 0) {
            throw Sql\NotFound::uuid($id);
        }

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return new Query\HashName($row['hash'], $row['name']);
    }

    public function countHashesById(string $id): Query\HashCount
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

        return new Query\HashCount($row['hash'], $row['count']);
    }
}
