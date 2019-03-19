<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain\Image;

use Radarlog\S3Uploader\Domain\Throwable;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
}
