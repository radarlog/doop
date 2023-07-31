<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Controller;

use Radarlog\Doop\Tests\ControllerTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadTest extends ControllerTestCase
{
    public function testAction(): void
    {
        $fixture = self::fixturePath('Images/avatar.jpg');

        $image = new UploadedFile($fixture, 'avatar.jpg');

        $this->client->request('POST', '/upload', [], [
            'upload' => [
                'image' => $image,
                'submit' => true,
            ],
        ]);

        self::assertResponseStatusCodeSame(302);
    }
}
