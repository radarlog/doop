<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command;

use Radarlog\Doop\Application\Command;

final class SpyHandler implements Command\Handler
{
    /** @var Command */
    public $command;

    public function handle(Command $command): void
    {
        $this->command = $command;
    }
}
