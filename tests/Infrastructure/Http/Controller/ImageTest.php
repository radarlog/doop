<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Domain;
use Radarlog\S3Uploader\Infrastructure\S3\Client;
use Radarlog\S3Uploader\Tests\ControllerTestCase;

class ImageTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $image = new Domain\Image('avatar.jpg', $content);

        self::$container->get(Client::class)->upload($image);
    }

    public function testAction(): void
    {
        $this->client->request('GET', '/image/avatar.jpg');

        $headers = $this->client->getResponse()->headers;

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame('image/jpeg', $headers->get('Content-Type'));
        $this->assertSame(5580, $headers->get('Content-Length'));
        $this->assertSame('attachment; filename=avatar.jpg', $headers->get('Content-Disposition'));
    }
}
