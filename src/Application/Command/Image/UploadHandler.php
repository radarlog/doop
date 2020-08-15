<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;

final class UploadHandler implements Command\Handler
{
    private Image\Uuid $uuid;

    private Domain\Storage $storage;

    private Domain\Repository $repository;

    public function __construct(Domain\Storage $storage, Domain\Repository $repository)
    {
        $this->uuid = Image\Identity::new();
        $this->storage = $storage;
        $this->repository = $repository;
    }

    /**
     * @param Command&Upload $command
     *
     * @throws Image\InvalidArgument
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function handle(Command $command): void
    {
        $file = new Image\File($command->content());

        $this->storage->upload($file);

        $name = new Image\Name($command->name());
        $image = new Image($this->uuid, $file->hash(), $name);

        $this->repository->add($image);
    }
}
