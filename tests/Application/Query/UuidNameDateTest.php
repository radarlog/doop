<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Query;

use Radarlog\Doop\Application\Query\UuidNameDate;
use Radarlog\Doop\Tests\UnitTestCase;

final class UuidNameDateTest extends UnitTestCase
{
    private const UUID = '572b3706-ffb8-423c-a317-d0ca8016a345';
    private const NAME = 'name';
    private const DATE = '2019-03-18 23:22:36';

    readonly private UuidNameDate $uuidNameDate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uuidNameDate = new UuidNameDate(self::UUID, self::NAME, self::DATE);
    }

    public function testUuid(): void
    {
        self::assertSame(self::UUID, $this->uuidNameDate->uuid());
    }

    public function testName(): void
    {
        self::assertSame(self::NAME, $this->uuidNameDate->name());
    }

    public function testUploadedAt(): void
    {
        self::assertSame(self::DATE, $this->uuidNameDate->uploadedAt());
    }
}
