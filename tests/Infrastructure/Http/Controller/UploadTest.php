<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Tests\ControllerTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadTest extends ControllerTestCase
{
    public function testAction(): void
    {
        $fixture = $this->fixturePath('Images/avatar.jpg');

        $image = new UploadedFile($fixture, 'avatar.jpg');

        $this->client->request('POST', '/upload', [], ['image' => $image]);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
