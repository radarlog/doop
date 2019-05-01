<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Sql\Read;

use Radarlog\S3Uploader\Application\Query;
use Radarlog\S3Uploader\Infrastructure\Sql\Connection;

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
            ->select('uuid, name, uploaded_at')
            ->from($this->connection->imagesTable())
            ->orderBy('uploaded_at', 'DESC');

        return $this->connection->project(
            $qb->getSQL(),
            $qb->getParameters(),
            static function (array $row) {
                return new Query\Image\UuidNameDate($row['uuid'], $row['name'], $row['uploaded_at']);
            }
        );
    }
}
