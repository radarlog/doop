<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Domain\Image;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class IdentityTest extends UnitTestCase
{
    public function testNonUuid(): void
    {
        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(Image\InvalidArgument::CODE_UUID);

        new Image\Identity('non-uuid');
    }

    public function testNew(): void
    {
        $identity = Image\Identity::new();

        self::assertSame(36, strlen($identity->toString()));
    }

    public function testToString(): void
    {
        $uuid = '572b3706-ffb8-423c-a317-d0ca8016a345';

        $identity = new Image\Identity($uuid);

        self::assertSame($uuid, $identity->toString());
    }
}
