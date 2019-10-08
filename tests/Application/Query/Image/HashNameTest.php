<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Query\Image;

use Radarlog\Doop\Application\Query\Image\HashName;
use Radarlog\Doop\Tests\UnitTestCase;

class HashNameTest extends UnitTestCase
{
    /** @var HashName */
    private $queryDto;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryDto = new HashName('hash', 'name');
    }

    public function testHash(): void
    {
        self::assertSame('hash', $this->queryDto->hash());
    }

    public function testName(): void
    {
        self::assertSame('name', $this->queryDto->name());
    }
}
