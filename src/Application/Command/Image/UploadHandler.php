<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;

final class UploadHandler implements Command\Handler
{
    /** @var Domain\Storage */
    private $storage;

    /** @var Domain\Repository */
    private $repository;

    public function __construct(Domain\Storage $storage, Domain\Repository $repository)
    {
        $this->storage = $storage;
        $this->repository = $repository;
    }

    /**
     * @param Upload $command
     *
     * @throws Image\InvalidArgument
     */
    public function handle(Command $command): void
    {
        $file = new Image\File($command->content());

        $this->storage->upload($file);

        $name = new Image\Name($command->name());
        $image = new Image($file->hash(), $name);

        $this->repository->add($image);
    }
}
