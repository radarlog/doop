<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\BrowserKitAssertionsTrait;
use Symfony\Component\BrowserKit\AbstractBrowser;

class ControllerTestCase extends DbTestCase
{
    use BrowserKitAssertionsTrait;

    protected AbstractBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var KernelBrowser $client */
        $client = self::$container->get('test.client');
        $client->disableReboot();

        $this->client = self::getClient($client);
    }
}
