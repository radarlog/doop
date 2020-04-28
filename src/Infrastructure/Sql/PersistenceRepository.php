<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Types\Types;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;

final class PersistenceRepository implements Repository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function add(Image $image): void
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

    public function getById(Image\Identity $id): Image
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('*')
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter($id->toString())),
            );

        /** @var Statement $stmt */
        $stmt = $qb->execute();

        if ($stmt->rowCount() === 0) {
            throw NotFound::uuid($id->toString());
        }

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        $state = new Image\State($row);

        return Image::fromState($state);
    }

    public function remove(Image\Identity $id): void
    {
        $this->connection->delete(
            $this->connection->imagesTable(),
            ['uuid' => $id->toString()],
            ['uuid' => Types::STRING],
        );
    }
}
