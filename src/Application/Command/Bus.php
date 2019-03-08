<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Command;

use Radarlog\S3Uploader\Application\Command;

interface Bus
{
    /**
     * Execute the command
     *
     * @throws RuntimeException
     */
    public function execute(Command $command): void;
}
