<?php
declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Radarlog\Doop\Domain\Throwable;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
}
