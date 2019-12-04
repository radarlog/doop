<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql\Read;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Infrastructure\Sql\Connection;

final class FindOneImage implements Query\Image\FindOne
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @psalm-suppress PossiblyInvalidMethodCall
     */
    public function hashNameByUuid(string $uuid): ?Query\Image\HashName
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select(['hash', 'name'])
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($uuid)),
            );

        $stmt = $qb->execute();

        if ($stmt->rowCount() === 0) {
            return null;
        }

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return new Query\Image\HashName($row['hash'], $row['name']);
    }
}
