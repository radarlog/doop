<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Application\Command;

use Radarlog\S3Uploader\Application\Command;

final class SpyHandler implements Command\Handler
{
    /** @var Command */
    public $command;

    public function handle(Command $command): void
    {
        $this->command = $command;
    }
}
