<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

class ImageTest extends UnitTestCase
{
    /** @var Image\Name */
    private $name;

    /** @var Image\Hash */
    private $hash;

    protected function setUp(): void
    {
        parent::setUp();

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

        $image = Image::fromState(new Image\State($origin));

        $state = $image->getState()->asArray();

        self::assertEquals(array_pop($origin), array_pop($state)); // uploaded_at
        self::assertSame($origin, $state);
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

    public function testFromStateWithWrongUploadedAtFormat(): void
    {
        $state = new Image\State([
            'uuid' => '572b3706-ffb8-423c-a317-d0ca8016a345',
            'hash' => 'f32b67c7e26342af42efabc674d441dca0a281c5',
            'name' => 'name',
            'uploaded_at' => '2019-03-18 23:22',
        ]);

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(Image\InvalidArgument::CODE_DATE);

        Image::fromState($state);
    }

    public function testGetState(): void
    {
        $image = new Image($this->hash, $this->name);

        $state = $image->getState();

        self::assertCount(4, $state->asArray());
    }

    public function testId(): void
    {
        $image = new Image($this->hash, $this->name);

        self::assertSame(36, strlen($image->id()->toString()));
    }
}
