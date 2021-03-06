<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Radarlog\Doop\Infrastructure\Throwable;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    final private function __construct(string $message, int $code, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function configuration(): self
    {
        return new self('Primary or replica configuration is missing', self::CODE_SQL_SERVERS);
    }
}
