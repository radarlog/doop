<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Controller;

use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\ControllerTestCase;

class ImageTest extends ControllerTestCase
{
    private Image\Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $file = new Image\File($content);

        $uuid = new Image\Uuid('572b3706-ffb8-423c-a317-d0ca8016a345');
        $name = new Image\Name('avatar.jpg');
        $image = new Image($uuid, $file->hash(), $name);

        $this->uuid = $image->uuid();

        /** @var Domain\Storage $storage */
        $storage = self::$container->get(Domain\Storage::class);
        $storage->upload($file);

        /** @var Domain\Repository $repository */
        $repository = self::$container->get(Domain\Repository::class);
        $repository->add($image);
    }

    public function testAction(): void
    {
        $this->client->request('GET', sprintf('/image/%s', (string) $this->uuid));

        self::assertResponseIsSuccessful();

        self::assertResponseHeaderSame('Content-Type', 'image/jpeg');
        self::assertResponseHeaderSame('Content-Length', '5580');
        self::assertResponseHeaderSame('Content-Disposition', 'attachment; filename=avatar.jpg');
    }

    public function testNotFound(): void
    {
        $this->client->request('GET', '/image/d3001bd8-f79f-4d91-802a-bebbd3c9d381');

        self::assertResponseStatusCodeSame(404);
    }
}
