<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Controller;

use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\ControllerTestCase;

final class ImageTest extends ControllerTestCase
{
    private const UUID = '572b3706-ffb8-423c-a317-d0ca8016a345';

    private Image\Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $file = new Image\File($content);

        $uuid = new Image\Uuid(self::UUID);
        $name = new Image\Name('avatar.jpg');
        $image = Image::new($uuid, $file->hash(), $name);

        $this->uuid = $image->uuid();

        $storage = self::getContainer()->get(Domain\Storage::class);
        $storage->upload($file);

        $repository = self::getContainer()->get(Domain\Repository::class);
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
