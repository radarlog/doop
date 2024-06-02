<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

final class ImageTest extends UnitTestCase
{
    private const string UUID = '572b3706-ffb8-723c-a317-d0ca8016a345';
    private const string HASH = '2080492d54a6b8579968901f366b13614fe188f2';
    private const string NAME = 'name';
    private const string DATE = '2019-03-18 23:22:36';

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
            'hash' => self::HASH,
            'name' => self::NAME,
            'uploaded_at' => self::DATE,
            'uuid' => self::UUID,
        ];

        $image = Image::fromState(new Image\State($origin));

        $state = $image->getState()->asArray();

        self::assertEquals(array_pop($origin), array_pop($state)); // uploaded_at
        self::assertSame($origin, $state);
    }

    public function testFromState(): void
    {
        $state = new Image\State([
            'hash' => self::HASH,
            'name' => self::NAME,
            'uploaded_at' => self::DATE,
            'uuid' => self::UUID,
        ]);

        $image = Image::fromState($state);

        self::assertSame(self::UUID, (string) $image->uuid());
    }

    public function testFromStateWithWrongUploadedAtFormat(): void
    {
        $state = new Image\State([
            'hash' => self::HASH,
            'name' => self::NAME,
            'uploaded_at' => '2019-03-18 23:22',
            'uuid' => self::UUID,
        ]);

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(1005);

        Image::fromState($state);
    }

    public function testGetState(): void
    {
        $image = Image::new($this->uuid, $this->hash, $this->name);

        $state = $image->getState();

        self::assertCount(4, $state->asArray());
    }

    public function testUuid(): void
    {
        $image = Image::new($this->uuid, $this->hash, $this->name);

        self::assertSame($this->uuid, $image->uuid());
    }
}
