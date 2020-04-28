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

    public function __construct(
        Domain\Storage $storage,
        Domain\Repository $repository,
        Query $query
    ) {
        $this->storage = $storage;
        $this->repository = $repository;
        $this->query = $query;
    }

    /**
     * @param Command&Remove $command
     *
     * @throws Image\InvalidArgument
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function handle(Command $command): void
    {
        $id = $command->id();

        $result = $this->query->countHashesById($id);

        $identity = new Image\Identity($id);
        $this->repository->remove($identity);

        if ($result->count() === 1) {
            $this->storage->delete($result->hash());
        }
    }
}
