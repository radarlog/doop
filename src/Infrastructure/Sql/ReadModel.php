<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Infrastructure\Sql;

final class ReadModel implements Query
{
    private readonly Sql\Connection $connection;

    public function __construct(Sql\Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findAllSortedByUploadDate(): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('uuid, name, uploaded_at')
            ->from($this->connection->imagesTable())
            ->orderBy('uploaded_at', 'DESC');

        $stmt = $qb->executeQuery();

        return array_map(
            static fn(array $row) => new Query\UuidNameDate(
                $row['uuid'],
                $row['name'],
                $row['uploaded_at'],
            ),
            $stmt->fetchAllAssociative(),
        );
    }

    public function findOneHashNameByUuid(string $uuid): Query\HashName
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('hash, name')
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($uuid)),
            );

        $stmt = $qb->executeQuery();

        if ($stmt->rowCount() === 0) {
            throw Sql\NotFound::uuid($uuid);
        }

        /** @var array{hash: string, name: string} $row */
        $row = $stmt->fetchAssociative();

        return new Query\HashName($row['hash'], $row['name']);
    }

    public function countHashesByUuid(string $uuid): Query\HashCount
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('i1.hash as hash, COUNT(i1.*) as count')
            ->from($this->connection->imagesTable(), 'i1')
            ->innerJoin('i1', $this->connection->imagesTable(), 'i2', 'i1.hash = i2.hash')
            ->where(
                $qb->expr()->eq('i1.uuid', $qb->createNamedParameter($uuid)),
            )
            ->groupBy('i1.hash');

        $stmt = $qb->executeQuery();

        if ($stmt->rowCount() === 0) {
            throw Sql\NotFound::uuid($uuid);
        }

        /** @var array{hash: string, count: int} $row */
        $row = $stmt->fetchAssociative();

        return new Query\HashCount($row['hash'], $row['count']);
    }
}
