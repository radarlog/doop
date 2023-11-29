<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class FunctionalTestCase extends KernelTestCase
{
    use Fixtures;

    protected function setUp(): void
    {
        parent::setUp();

        self::$kernel = self::bootKernel();
        assert(self::$kernel instanceof KernelInterface);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        self::ensureKernelShutdown();
    }
}
