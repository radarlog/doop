<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql\Read;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Infrastructure\Sql;

final class FindAllImages implements Query\Image\FindAll
{
    private Sql\Connection $connection;

    public function __construct(Sql\Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritdoc
     */
    public function sortedByUploadDate(): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select(['uuid, name, uploaded_at'])
            ->from($this->connection->imagesTable())
            ->orderBy('uploaded_at', 'DESC');

        return $this->connection->project(
            $qb->getSQL(),
            $qb->getParameters(),
            static fn(array $row) => new Query\Image\UuidNameDate(
                $row['uuid'],
                $row['name'],
                $row['uploaded_at'],
            ),
        );
    }
}
