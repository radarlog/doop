<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Application\Query\Image;

use Radarlog\S3Uploader\Application\Query\Image\UuidNameDate;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class UuidNameDateTest extends UnitTestCase
{
    /** @var UuidNameDate */
    private $queryDto;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryDto = new UuidNameDate('uuid', 'name', '2018-01-01 23:22:36');
    }

    public function testUuid(): void
    {
        self::assertSame('uuid', $this->queryDto->uuid());
    }

    public function testName(): void
    {
        self::assertSame('name', $this->queryDto->name());
    }

    public function testUploadedAt(): void
    {
        self::assertSame('2018-01-01 23:22:36', $this->queryDto->uploadedAt());
    }
}