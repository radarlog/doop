<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Infrastructure\S3;
use Radarlog\Doop\Tests\FunctionalTestCase;

final class ClientTest extends FunctionalTestCase
{
    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';

    private Image\Hash $hash;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hash = new Image\Hash(self::HASH);
    }

    public function testUpload(): void
    {
        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $file = new Image\File($content);

        $client = self::getContainer()->get(S3\Client::class);

        $client->upload($file);

        $object = $client->download($this->hash);

        self::assertSame((string) $file->hash(), (string) $object->hash());
        self::assertSame($content, $object->content());
    }

    public function downloadNonExistingHash(): void
    {
        $client = self::getContainer()->get(S3\Client::class);

        $this->expectException(Image\NotFound::class);
        $this->expectExceptionCode(1008);

        $client->download($this->hash);
    }

    public function testDelete(): void
    {
        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $file = new Image\File($content);

        $client = self::getContainer()->get(S3\Client::class);

        $client->upload($file);
        $client->delete($this->hash);

        $this->expectException(Image\NotFound::class);
        $this->expectExceptionCode(1008);

        $client->download($this->hash);
    }
}
