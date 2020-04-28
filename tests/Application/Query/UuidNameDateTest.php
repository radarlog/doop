<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Query;

use Radarlog\Doop\Application\Query\UuidNameDate;
use Radarlog\Doop\Tests\UnitTestCase;

class UuidNameDateTest extends UnitTestCase
{
    private UuidNameDate $uuidNameDate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uuidNameDate = new UuidNameDate('uuid', 'name', '2018-01-01 23:22:36');
    }

    public function testUuid(): void
    {
        self::assertSame('uuid', $this->uuidNameDate->uuid());
    }

    public function testName(): void
    {
        self::assertSame('name', $this->uuidNameDate->name());
    }

    public function testUploadedAt(): void
    {
        self::assertSame('2018-01-01 23:22:36', $this->uuidNameDate->uploadedAt());
    }
}
