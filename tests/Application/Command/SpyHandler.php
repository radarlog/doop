<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command;

use Radarlog\Doop\Application\Command;

final class SpyHandler implements Command\Handler
{
    private ?Command $command;

    public function __construct()
    {
        $this->command = null;
    }

    public function handle(Command $command): void
    {
        $this->command = $command;
    }

    public function command(): ?Command
    {
        return $this->command;
    }
}
