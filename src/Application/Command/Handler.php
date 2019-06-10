<?php
declare(strict_types=1);

namespace Radarlog\Doop\Application\Command;

use Radarlog\Doop\Application\Command;

interface Handler
{
    public function handle(Command $command): void;
}
