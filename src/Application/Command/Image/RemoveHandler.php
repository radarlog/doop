<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;

final class RemoveHandler implements Command\Handler
{
    private Domain\Storage $storage;

    private Domain\Repository $repository;

    private Query $query;

    public function __construct(Domain\Storage $storage, Domain\Repository $repository, Query $query)
    {
        $this->storage = $storage;
        $this->repository = $repository;
        $this->query = $query;
    }

    /**
     * @throws Image\InvalidArgument
     */
    public function handle(Command|Remove $command): void
    {
        $uuid = $command->uuid();

        $result = $this->query->countHashesByUuid($uuid);

        $uuid = new Image\Uuid($uuid);
        $this->repository->remove($uuid);

        if ($result->count() === 1) {
            $this->storage->delete($result->hash());
        }
    }
}
