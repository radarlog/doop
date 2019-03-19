<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader;

interface Throwable extends \Throwable
{
    # @formatter:off
    public const CODE_IMAGE          = 1000;
    public const CODE_UUID           = 1001;
    public const CODE_STATE          = 1002;
    public const CODE_NAME           = 1003;

    public const CODE_HANDLER        = 2000;
    public const CODE_MYSQL_SEVERS   = 3000;
    # @formatter:on
}
