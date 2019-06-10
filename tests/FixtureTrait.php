<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests;

trait FixtureTrait
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
