<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Cli;

use Radarlog\Doop\Infrastructure\Throwable;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
}
