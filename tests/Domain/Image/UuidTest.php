<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use PHPUnit\Framework\Attributes\DataProvider;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

final class UuidTest extends UnitTestCase
{
    private const string UUID = '572b3706-ffb8-723c-a317-d0ca8016a345';

    /**
     * @return iterable<array<int,string>>
     */
    public static function invalidUuidProvider(): iterable
    {
        yield 'empty' => [''];
        yield 'non uuid' => ['uuid'];
        yield 'uuid4' => ['572b3706-ffb8-423c-a317-d0ca8016a345'];
        yield 'with trailing eol' => ["572b3706-ffb8-723c-a317-d0ca8016a345\n"];
        yield 'with leading eol' => ["\n572b3706-ffb8-723c-a317-d0ca8016a345"];
    }

    #[DataProvider('invalidUuidProvider')]
    public function testInvalidUuid(string $uuid): void
    {
        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(1001);

        new Image\Uuid($uuid);
    }

    public function testToString(): void
    {
        $uuid = new Image\Uuid(self::UUID);

        self::assertSame(self::UUID, (string) $uuid);
    }
}
