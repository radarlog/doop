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

    public function hashNameByUuid(string $uuid): ?array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('hash', 'name')
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($uuid))
            );

        $stmt = $qb->execute();

        if ($stmt->rowCount() === 0) {
            return null;
        }

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
