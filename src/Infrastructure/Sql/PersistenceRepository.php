<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Doctrine\DBAL\Types\Types;
use Radarlog\Doop\Domain;

final class PersistenceRepository implements Domain\Repository
{
    private Connection $connection;

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
                'uuid' => Types::STRING,
                'hash' => Types::STRING,
                'name' => Types::STRING,
                'uploaded_at' => Types::STRING,
            ],
            );
    }

    /**
     * @psalm-suppress PossiblyInvalidMethodCall
     */
    public function getById(Domain\Identity $id): ?Domain\Aggregate
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('*')
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($id->toString())),
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
