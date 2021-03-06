<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

class ImageTest extends UnitTestCase
{
    private const UUID = '572b3706-ffb8-423c-a317-d0ca8016a345';
    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';
    private const NAME = 'name';
    private const DATE = '2019-03-18 23:22:36';

    private Image\Uuid $uuid;

    private Image\Name $name;

    private Image\Hash $hash;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uuid = new Image\Uuid(self::UUID);
        $this->name = new Image\Name(self::NAME);
        $this->hash = new Image\Hash(self::HASH);
    }

    public function testState(): void
    {
        $origin = [
            'uuid' => self::UUID,
            'hash' => self::HASH,
            'name' => self::NAME,
            'uploaded_at' => self::DATE,
        ];

        $image = Image::fromState(new Image\State($origin));

        $state = $image->getState()->asArray();

        self::assertEquals(array_pop($origin), array_pop($state)); // uploaded_at
        self::assertSame($origin, $state);
    }

    public function testFromState(): void
    {
        $state = new Image\State([
            'uuid' => self::UUID,
            'hash' => self::HASH,
            'name' => self::NAME,
            'uploaded_at' => self::DATE,
        ]);

        $image = Image::fromState($state);

        self::assertSame(self::UUID, (string) $image->uuid());
    }

    public function testFromStateWithWrongUploadedAtFormat(): void
    {
        $state = new Image\State([
            'uuid' => self::UUID,
            'hash' => self::HASH,
            'name' => self::NAME,
            'uploaded_at' => '2019-03-18 23:22',
        ]);

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(1005);

        Image::fromState($state);
    }

    public function testGetState(): void
    {
        $image = new Image($this->uuid, $this->hash, $this->name);

        $state = $image->getState();

        self::assertCount(4, $state->asArray());
    }

    public function testUuid(): void
    {
        $image = new Image($this->uuid, $this->hash, $this->name);

        self::assertSame($this->uuid, $image->uuid());
    }
}
