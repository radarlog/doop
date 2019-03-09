<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader;

interface Throwable extends \Throwable
{
    # @formatter:off
    public const CODE_IMAGE          = 1000;
    public const CODE_HANDLER        = 2000;
    # @formatter:on
}
