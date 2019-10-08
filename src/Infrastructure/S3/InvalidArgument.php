<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use Radarlog\Doop\Throwable;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
}
