<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Cli;

use Radarlog\S3Uploader\Throwable;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
}
