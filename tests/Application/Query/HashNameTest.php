<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Query;

use Radarlog\Doop\Application\Query\HashName;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

final class HashNameTest extends UnitTestCase
{
    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';
    private const NAME = 'name';

    readonly private HashName $hashName;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hashName = new HashName(self::HASH, self::NAME);
    }

    public function testHash(): void
    {
        $hash = new Image\Hash(self::HASH);

        self::assertEquals($hash, $this->hashName->hash());
    }

    public function testName(): void
    {
        $name = new Image\Name(self::NAME);

        self::assertEquals($name, $this->hashName->name());
    }
}
