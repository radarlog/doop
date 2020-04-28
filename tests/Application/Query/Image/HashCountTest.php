<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Query\Image;

use Radarlog\Doop\Application\Query\Image\HashCount;
use Radarlog\Doop\Domain\Image\Hash;
use Radarlog\Doop\Tests\UnitTestCase;

class HashCountTest extends UnitTestCase
{
    private HashCount $queryDto;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryDto = new HashCount('f32b67c7e26342af42efabc674d441dca0a281c5', 2);
    }

    public function testHash(): void
    {
        $hash = new Hash('f32b67c7e26342af42efabc674d441dca0a281c5');

        self::assertEquals($hash, $this->queryDto->hash());
    }

    public function testCount(): void
    {
        self::assertSame(2, $this->queryDto->count());
    }
}
