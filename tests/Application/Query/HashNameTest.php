<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Query;

use Radarlog\Doop\Application\Query\HashName;
use Radarlog\Doop\Domain\Image\Hash;
use Radarlog\Doop\Tests\UnitTestCase;

class HashNameTest extends UnitTestCase
{
    private HashName $hashName;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hashName = new HashName('f32b67c7e26342af42efabc674d441dca0a281c5', 'name');
    }

    public function testHash(): void
    {
        $hash = new Hash('f32b67c7e26342af42efabc674d441dca0a281c5');

        self::assertEquals($hash, $this->hashName->hash());
    }

    public function testName(): void
    {
        self::assertSame('name', (string) $this->hashName->name());
    }
}
