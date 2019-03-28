<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Application\Query\Image;

use Radarlog\S3Uploader\Application\Query\Image\UuidName;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class UuidNameTest extends UnitTestCase
{
    /** @var UuidName */
    private $queryDto;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryDto = new UuidName('uuid', 'name');
    }

    public function testUuid(): void
    {
        self::assertSame('uuid', $this->queryDto->uuid());
    }

    public function testName(): void
    {
        self::assertSame('name', $this->queryDto->name());
    }
}
