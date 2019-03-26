<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\MySql\Read;

use Radarlog\S3Uploader\Application\Query;
use Radarlog\S3Uploader\Infrastructure\MySql\Connection;

final class FindAllImages implements Query\Image\FindAll
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function sortedByUploadDate(): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('uuid, name')
            ->from($this->connection->imagesTable())
            ->orderBy('uploaded_at', 'DESC');

        return $qb->execute()->fetchAll(\PDO::FETCH_ASSOC);
    }
}
