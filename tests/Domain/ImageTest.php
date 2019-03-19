<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Domain;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class ImageTest extends UnitTestCase
{
    /** @var Image\Identity */
    private $uuid;

    /** @var Image\Name */
    private $name;

    /** @var Image\Hash */
    private $hash;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uuid = Image\Identity::new();
        $this->name = new Image\Name('name');
        $this->hash = new Image\Hash('f32b67c7e26342af42efabc674d441dca0a281c5');
    }

    public function testState(): void
    {
        $origin = [
            'uuid' => '572b3706-ffb8-423c-a317-d0ca8016a345',
            'hash' => 'f32b67c7e26342af42efabc674d441dca0a281c5',
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
            'hash' => 'f32b67c7e26342af42efabc674d441dca0a281c5',
            'name' => 'name',
            'uploaded_at' => '2019-03-18 23:22:36',
        ]);

        $image = Image::fromState($state);

        self::assertSame('572b3706-ffb8-423c-a317-d0ca8016a345', $image->id()->toString());
    }

    public function testGetState(): void
    {
        $image = new Image($this->uuid, $this->hash, $this->name);

        $state = $image->getState();

        self::assertCount(4, $state->asArray());
    }

    public function testId(): void
    {
        $image = new Image($this->uuid, $this->hash, $this->name);

        self::assertSame($this->uuid->toString(), $image->id()->toString());
    }
}
