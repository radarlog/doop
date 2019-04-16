<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Command;

use Radarlog\S3Uploader\Application\Command;
use Radarlog\S3Uploader\Domain;

interface Bus
{
    /**
     * Execute the command
     *
     * @throws Domain\Throwable
     * @throws RuntimeException
     */
    public function execute(Command $command): void;
}
