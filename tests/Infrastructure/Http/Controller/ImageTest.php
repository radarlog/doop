<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Controller;

use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\ControllerTestCase;

class ImageTest extends ControllerTestCase
{
    /** @var Domain\Identity */
    private $uuid;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $file = new Image\File($content);

        $name = new Image\Name('avatar.jpg');
        $image = new Image($file->hash(), $name);

        $this->uuid = $image->id();

        self::$container->get(Domain\Storage::class)->upload($file);
        self::$container->get(Domain\Repository::class)->add($image);
    }

    public function testAction(): void
    {
        $this->client->request('GET', sprintf('/image/%s', $this->uuid->toString()));

        self::assertResponseIsSuccessful();

        self::assertResponseHeaderSame('Content-Type', 'image/jpeg');
        self::assertResponseHeaderSame('Content-Length', '5580');
        self::assertResponseHeaderSame('Content-Disposition', 'attachment; filename=avatar.jpg');
    }

    public function testNotFound(): void
    {
        $this->client->request('GET', '/image/572b3706-ffb8-423c-a317-d0ca8016a345');

        self::assertResponseStatusCodeSame(404);
    }
}
