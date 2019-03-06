<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests;

use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    protected function fixturePath(string $path): string
    {
        $path = __DIR__ . '/Fixtures/' . ltrim($path, DIRECTORY_SEPARATOR);

        if (!file_exists($path)) {
            throw new \RuntimeException(sprintf('Fixture "%s" does not exist', $path));
        }

        return $path;
    }
}
