<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

class IdentityTest extends UnitTestCase
{
    public function testNonUuid(): void
    {
        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(1001);

        new Image\Identity('non-uuid');
    }

    public function testNew(): void
    {
        $identity = Image\Identity::new();

        self::assertSame(36, strlen((string) $identity));
    }

    public function testToString(): void
    {
        $uuid = '572b3706-ffb8-423c-a317-d0ca8016a345';

        $identity = new Image\Identity($uuid);

        self::assertSame($uuid, (string) $identity);
    }
}
