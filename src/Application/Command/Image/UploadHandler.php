<?php
declare(strict_types=1);

namespace Radarlog\Doop\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;

final class UploadHandler implements Command\Handler
{
    /** @var Domain\Storage */
    private $client;

    /** @var Domain\Repository */
    private $repository;

    public function __construct(Domain\Storage $client, Domain\Repository $repository)
    {
        $this->client = $client;
        $this->repository = $repository;
    }

    /**
     * @param Upload $command
     *
     * @throws Domain\Image\InvalidArgument
     */
    public function handle(Command $command): void
    {
        $name = new Image\Name($command->name());
        $hash = Image\Hash::calculate($command->content());

        $file = new Image\File($hash, $command->content());
        $this->client->upload($file);

        $image = new Image($hash, $name);
        $this->repository->add($image);
    }
}
