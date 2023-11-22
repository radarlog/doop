<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;

final class DeleteHandler implements Command\Handler
{
    private readonly Domain\Storage $storage;

    private readonly Domain\Repository $repository;

    private readonly Query $query;

    public function __construct(Domain\Storage $storage, Domain\Repository $repository, Query $query)
    {
        $this->storage = $storage;
        $this->repository = $repository;
        $this->query = $query;
    }

    /**
     * @param Command&Delete $command
     *
     * @throws Image\InvalidArgument
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function handle(Command $command): void
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
