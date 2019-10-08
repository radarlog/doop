<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command;

use Radarlog\Doop\Application\Throwable;

class RuntimeException extends \RuntimeException implements Throwable
{
}
