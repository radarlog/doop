<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Domain;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class ImageTest extends UnitTestCase
{
    /** @var Image\Identity */
    private $uuid;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uuid = Image\Identity::new();
    }

    public function testState(): void
    {
        $origin = [
            'uuid' => '572b3706-ffb8-423c-a317-d0ca8016a345',
            'hash' => 'hash',
            'name' => 'name',
            'uploaded_at' => '2019-03-18 23:22:36',
        ];

        $state = new Image\State($origin);

        $image = Image::fromState($state);

        self::assertSame($origin, $image->getState()->asArray());
    }

    public function testFromState(): void
    {
        $state = new Image\State([
            'uuid' => '572b3706-ffb8-423c-a317-d0ca8016a345',
            'hash' => 'hash',
            'name' => 'name',
            'uploaded_at' => '2019-03-18 23:22:36',
        ]);

        $image = Image::fromState($state);

        self::assertSame('572b3706-ffb8-423c-a317-d0ca8016a345', $image->id()->toString());
    }

    public function testGetState(): void
    {
        $image = new Image($this->uuid, 'hash', 'name');

        $state = $image->getState();

        self::assertCount(4, $state->asArray());
    }

    public function testId(): void
    {
        $image = new Image($this->uuid, 'hash', 'name');

        self::assertSame($this->uuid->toString(), $image->id()->toString());
    }
}
