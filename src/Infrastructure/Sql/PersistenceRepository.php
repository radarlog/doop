<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Doctrine\DBAL\Types\Types;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Symfony\Component\Uid\Uuid;

final readonly class PersistenceRepository implements Repository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function newUuid(): Image\Uuid
    {
        $uuid = (string) Uuid::v7();

        return new Image\Uuid($uuid);
    }

    public function add(Image $image): void
    {
        $this->connection->insert(
            $this->connection->imagesTable(),
            $image->getState()->asArray(),
            [
                'hash' => Types::STRING,
                'name' => Types::STRING,
                'uploaded_at' => Types::STRING,
                'uuid' => Types::STRING,
            ],
        );
    }

    public function getByUuid(Image\Uuid $uuid): Image
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('*')
            ->from($this->connection->imagesTable())
            ->where(
                $qb->expr()->eq('uuid', $qb->createNamedParameter((string) $uuid)),
            );

        $stmt = $qb->executeQuery();

        if ($stmt->rowCount() === 0) {
            throw Image\NotFound::uuid((string) $uuid);
        }

        /** @var array{uuid: string, hash: string, name: string, uploaded_at: string} $row */
        $row = $stmt->fetchAssociative();

        $state = new Image\State($row);

        return Image::fromState($state);
    }

    public function remove(Image\Uuid $uuid): void
    {
        $this->connection->delete(
            $this->connection->imagesTable(),
            ['uuid' => (string) $uuid],
            ['uuid' => Types::STRING],
        );
    }
}
