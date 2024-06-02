<?php

declare(strict_types=1);

namespace Radarlog\Doop;

// phpcs:disable SlevomatCodingStandard.Whitespaces.DuplicateSpaces
interface Throwable extends \Throwable
{
    // @formatter:off

    // DOMAIN LAYER
    public const int CODE_UUID           = 1001;
    public const int CODE_STATE          = 1002;
    public const int CODE_NAME           = 1003;
    public const int CODE_HASH           = 1004;
    public const int CODE_DATE           = 1005;
    public const int CODE_MIME_TYPE      = 1006;
    public const int CODE_UUID_NOT_FOUND = 1007;
    public const int CODE_HASH_NOT_FOUND = 1008;

    // APPLICATION LAYER
    public const int CODE_HANDLER        = 2000;

    // INFRASTRUCTURE LAYER
    public const int CODE_CLI_FILE_READ  = 3100;
    public const int CODE_S3_ENDPOINT    = 3200;

    // @formatter:on
}
