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

    public function hashNameById(string $id): Query\Image\HashName
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

        return new Query\Image\HashName($row['hash'], $row['name']);
    }
}
