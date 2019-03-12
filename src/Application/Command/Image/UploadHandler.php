<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Command\Image;

use Radarlog\S3Uploader\Application\Command;
use Radarlog\S3Uploader\Domain;

final class UploadHandler implements Command\Handler
{
    /** @var Domain\Storage */
    private $client;

    public function __construct(Domain\Storage $client)
    {
        $this->client = $client;
    }

    /**
     * @param Upload $command
     *
     * @throws Domain\Image\InvalidArgument
     */
    public function handle(Command $command): void
    {
        $file = new Domain\Image\File($command->name(), $command->content());

        $this->client->upload($file);
    }
}
