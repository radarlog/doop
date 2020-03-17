<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql\Read;

use Doctrine\DBAL\Driver\Statement;
use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Infrastructure\Sql;

final class FindOneImage implements Query\Image\FindOne
{
    private Sql\Connection $connection;

    public function __construct(Sql\Connection $connection)
    {
        $this->connection = $connection;
    }

    public function hashNameByUuid(string $uuid): Query\Image\HashName
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select(['hash', 'name'])
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($uuid)),
            );

        /** @var Statement $stmt */
        $stmt = $qb->execute();

        if ($stmt->rowCount() === 0) {
            throw new Sql\NotFound('Not found', Sql\NotFound::CODE_SQL_NOT_FOUND);
        }

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return new Query\Image\HashName($row['hash'], $row['name']);
    }
}
