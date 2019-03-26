<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\S3;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Infrastructure\S3\Client;
use Radarlog\S3Uploader\Tests\FunctionalTestCase;

class ClientTest extends FunctionalTestCase
{
    /** @var string */
    private $hash = '2080492d54a6b8579968901f366b13614fe188f2';

    public function testUpload(): void
    {
        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $hash = new Image\Hash($this->hash);

        $file = new Image\File($hash, $content);

        $client = self::$container->get(Client::class);

        $client->upload($file);

        $object = $client->get($this->hash);

        self::assertSame($this->hash, $object->hash());
        self::assertSame($content, $object->content());
    }
}
