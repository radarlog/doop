<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
    # @formatter:off
    public const CODE_PICTURE          = 1000;
    # @formatter:on
}
