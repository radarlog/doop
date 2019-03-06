<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Tests\ControllerTestCase;

class IndexTest extends ControllerTestCase
{
    public function testAction(): void
    {
        $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
