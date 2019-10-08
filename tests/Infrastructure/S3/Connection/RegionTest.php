<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3\Connection;

use Radarlog\Doop\Infrastructure\S3\Connection\Region;
use Radarlog\Doop\Tests\UnitTestCase;

class RegionTest extends UnitTestCase
{
    public function testName(): void
    {
        $region = new Region('region');

        self::assertSame('region', $region->name());
    }
}
