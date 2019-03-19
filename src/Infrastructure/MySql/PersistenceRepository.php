<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\MySql;

use Doctrine\DBAL\Types\Type;
use Radarlog\S3Uploader\Domain;

final class PersistenceRepository implements Domain\Repository
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function add(Domain\Image $image): void
    {
        $table = $this->connection->imagesTable();

        $this->connection->insert(
            $this->connection->quoteIdentifier($table),
            $image->getState()->asArray(),
            [
                'uuid' => Type::STRING,
                'hash' => Type::STRING,
                'name' => Type::STRING,
                'uploaded_at' => Type::STRING,
            ]
        );
    }

    public function getById(Domain\Image\Identity $id): Domain\Image
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('*')
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($id->toString()))
            );

        $row = $qb->execute()->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_FIRST);

        $state = new Domain\Image\State($row);

        return Domain\Image::fromState($state);
    }
}
