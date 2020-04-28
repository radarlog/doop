<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Query;

use Radarlog\Doop\Application\Query\HashCount;
use Radarlog\Doop\Domain\Image\Hash;
use Radarlog\Doop\Tests\UnitTestCase;

class HashCountTest extends UnitTestCase
{
    private HashCount $hashCount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hashCount = new HashCount('f32b67c7e26342af42efabc674d441dca0a281c5', 2);
    }

    public function testHash(): void
    {
        $hash = new Hash('f32b67c7e26342af42efabc674d441dca0a281c5');

        self::assertEquals($hash, $this->hashCount->hash());
    }

    public function testCount(): void
    {
        self::assertSame(2, $this->hashCount->count());
    }
}
