<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Infrastructure\S3\Client;
use Radarlog\Doop\Tests\FunctionalTestCase;

class ClientTest extends FunctionalTestCase
{
    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';

    public function testUpload(): void
    {
        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $file = new Image\File($content);

        $client = self::$container->get(Client::class);

        $client->upload($file);

        $object = $client->download(self::HASH);

        self::assertSame((string) $file->hash(), (string) $object->hash());
        self::assertSame($content, $object->content());
    }
}
