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
     * @throws Domain\InvalidArgument
     */
    public function handle(Command $command): void
    {
        $image = new Domain\Image($command->name(), $command->content());

        $this->client->upload($image);
    }
}
