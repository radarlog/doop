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

    public function add(Domain\Aggregate $image): void
    {
        $this->connection->insert(
            $this->connection->imagesTable(),
            $image->getState()->asArray(),
            [
                'uuid' => Type::STRING,
                'hash' => Type::STRING,
                'name' => Type::STRING,
                'uploaded_at' => Type::STRING,
            ]
        );
    }

    public function getById(Domain\Identity $id): ?Domain\Aggregate
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('*')
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($id->toString()))
            );

        $stmt = $qb->execute();

        if ($stmt->rowCount() === 0) {
            return null;
        }

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        $state = new Domain\Image\State($row);

        return Domain\Image::fromState($state);
    }
}
