<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;

class ControllerTestCase extends DbTestCase
{
    use WebTestAssertionsTrait;

    /** @var KernelBrowser */
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $client = self::$container->get('test.client');
        $client->disableReboot();

        $this->client = self::getClient($client);
    }
}
