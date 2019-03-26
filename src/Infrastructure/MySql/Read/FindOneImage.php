<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\MySql\Read;

use Radarlog\S3Uploader\Application\Query;
use Radarlog\S3Uploader\Infrastructure\MySql\Connection;

final class FindOneImage implements Query\Image\FindOne
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function hashByUuid(string $uuid): ?string
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('hash')
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($uuid))
            );

        $stmt = $qb->execute();

        if ($stmt->rowCount() === 0) {
            return null;
        }

        return (string)$stmt->fetchColumn();
    }
}
