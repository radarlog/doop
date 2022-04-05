<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Query;

use Radarlog\Doop\Application\Query\HashCount;
use Radarlog\Doop\Domain\Image\Hash;
use Radarlog\Doop\Tests\UnitTestCase;

final class HashCountTest extends UnitTestCase
{
    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';

    private HashCount $hashCount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hashCount = new HashCount(self::HASH, 2);
    }

    public function testHash(): void
    {
        $hash = new Hash(self::HASH);

        self::assertEquals($hash, $this->hashCount->hash());
    }

    public function testCount(): void
    {
        self::assertSame(2, $this->hashCount->count());
    }
}
