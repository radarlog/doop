<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\S3;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Infrastructure\S3\Client;
use Radarlog\S3Uploader\Tests\FunctionalTestCase;

class ClientTest extends FunctionalTestCase
{
    public function testUpload(): void
    {
        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $image = new Image('avatar.jpg', $content);

        $client = self::$container->get(Client::class);

        $client->upload($image);

        $objects = $client->list();

        $key = $client->list()->current();

        self::assertNotEmpty($objects);
        self::assertSame('avatar.jpg', $key);
        self::assertSame($content, $client->get($key)->content());
    }
}
