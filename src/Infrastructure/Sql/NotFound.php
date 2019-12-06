<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Radarlog\Doop\Throwable;

class NotFound extends \RuntimeException implements Throwable
{
}
