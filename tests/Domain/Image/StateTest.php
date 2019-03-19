<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Domain\Image;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class StateTest extends UnitTestCase
{
    public function invalidKeysProvider(): \Generator
    {
        yield 'missing all keys' => [['key' => 'value']];
        yield 'redundant key' => [['uuid' => 'u', 'hash' => 'h', 'name' => 'n', 'uploaded_at' => 'd', 'k' => 'v']];
        yield 'missing 1 key' => [['uuid' => 'uuid', 'hash' => 'hash', 'name' => 'name']];
    }

    /**
     * @dataProvider invalidKeysProvider
     */
    public function testInvalidKeysThrowException(array $state): void
    {
        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(Image\InvalidArgument::CODE_STATE);

        new Image\State($state);
    }

    public function testInvalidDate(): void
    {
        $origin = ['uuid' => 'uuid', 'hash' => 'hash', 'name' => 'name', 'uploaded_at' => 'date'];

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(Image\InvalidArgument::CODE_STATE);

        new Image\State($origin);
    }


    public function testAsArray(): void
    {
        $origin = ['uuid' => 'uuid', 'hash' => 'hash', 'name' => 'name', 'uploaded_at' => '2019-03-18 23:22:36'];

        $state = new Image\State($origin);

        self::assertSame($origin, $state->asArray());
    }
}
