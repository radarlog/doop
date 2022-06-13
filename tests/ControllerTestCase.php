<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\BrowserKitAssertionsTrait;

abstract class ControllerTestCase extends DbTestCase
{
    use BrowserKitAssertionsTrait;

    readonly protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var KernelBrowser $client */
        $client = self::getContainer()->get('test.client');
        $client->disableReboot();

        /** @var KernelBrowser $client */
        $client = self::getClient($client);

        $this->client = $client;
    }
}
