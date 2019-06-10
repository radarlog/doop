<?php
declare(strict_types=1);

namespace Radarlog\Doop\Application\Command;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Domain;

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
