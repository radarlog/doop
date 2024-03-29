<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Cli;

use Radarlog\Doop\Infrastructure\Throwable;

final class InvalidArgument extends \InvalidArgumentException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    private function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }

    public static function file(string $path): self
    {
        return new self(sprintf('File "%s" is not readable', $path), self::CODE_CLI_FILE_READ);
    }
}
