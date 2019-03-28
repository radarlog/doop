<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Application\Query\Image;

use Radarlog\S3Uploader\Application\Query\Image\HashName;
use Radarlog\S3Uploader\Tests\UnitTestCase;

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
