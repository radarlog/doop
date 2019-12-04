<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
use Symfony\Component\BrowserKit\AbstractBrowser;

class ControllerTestCase extends DbTestCase
{
    use WebTestAssertionsTrait;

    /** @var AbstractBrowser */
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $client = self::$container->get('test.client');
        $client->disableReboot();

        $this->client = self::getClient($client);
    }
}
