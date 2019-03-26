<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Infrastructure\S3\Client;
use Radarlog\S3Uploader\Tests\ControllerTestCase;

class ImageTest extends ControllerTestCase
{
    /** @var string */
    private $hash = '2080492d54a6b8579968901f366b13614fe188f2';

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $hash = new Image\Hash($this->hash);

        $file = new Image\File($hash, $content);

        self::$container->get(Client::class)->upload($file);
    }

    public function testAction(): void
    {
        $this->client->request('GET', sprintf('/image/%s', $this->hash));

        $headers = $this->client->getResponse()->headers;

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame('image/jpeg', $headers->get('Content-Type'));
        $this->assertSame(5580, $headers->get('Content-Length'));
        $this->assertSame(sprintf('attachment; filename=%s', $this->hash), $headers->get('Content-Disposition'));
    }
}
