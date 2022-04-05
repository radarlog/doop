<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Controller;

use Radarlog\Doop\Tests\ControllerTestCase;

final class IndexTest extends ControllerTestCase
{
    public function testAction(): void
    {
        $this->client->request('GET', '/');

        self::assertResponseIsSuccessful();
    }
}
