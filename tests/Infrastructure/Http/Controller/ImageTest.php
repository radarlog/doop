<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Domain;
use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Tests\ControllerTestCase;

class ImageTest extends ControllerTestCase
{
    /** @var string */
    private $hash = '2080492d54a6b8579968901f366b13614fe188f2';

    /** @var Domain\Identity */
    private $uuid;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $hash = new Image\Hash($this->hash);

        $file = new Image\File($hash, $content);

        $name = new Image\Name('avatar.jpg');
        $image = new Image($hash, $name);

        $this->uuid = $image->id();

        self::$container->get(Domain\Storage::class)->upload($file);
        self::$container->get(Domain\Repository::class)->add($image);
    }

    public function testAction(): void
    {
        $this->client->request('GET', sprintf('/image/%s', $this->uuid->toString()));

        $headers = $this->client->getResponse()->headers;

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame('image/jpeg', $headers->get('Content-Type'));
        $this->assertSame(5580, $headers->get('Content-Length'));
        $this->assertSame(sprintf('attachment; filename=%s', $this->hash), $headers->get('Content-Disposition'));
    }
}
