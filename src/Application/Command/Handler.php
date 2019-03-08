<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Command;

use Radarlog\S3Uploader\Application\Command;

interface Handler
{
    public function handle(Command $command): void;
}
