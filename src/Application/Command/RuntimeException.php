<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Command;

use Radarlog\S3Uploader\Application\Throwable;

class RuntimeException extends \RuntimeException implements Throwable
{
}
