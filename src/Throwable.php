<?php
declare(strict_types=1);

namespace Radarlog\Doop;

interface Throwable extends \Throwable
{
    # @formatter:off

    # DOMAIN LAYER
    public const CODE_IMAGE          = 1000;
    public const CODE_UUID           = 1001;
    public const CODE_STATE          = 1002;
    public const CODE_NAME           = 1003;
    public const CODE_HASH           = 1004;
    public const CODE_DATE           = 1005;

    # APPLICATION LAYER
    public const CODE_HANDLER        = 2000;

    # INFRASTRUCTURE LAYER
    public const CODE_SQL_SERVERS    = 3000;
    public const CODE_READ_FILE      = 3100;

    # @formatter:on
}
