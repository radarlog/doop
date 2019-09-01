<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests;

use Radarlog\Doop\Infrastructure\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FunctionalTestCase extends KernelTestCase
{
    use Fixtures;

    /** @var Kernel */
    protected static $kernel;

    protected function setUp(): void
    {
        parent::setUp();

        self::$kernel = self::bootKernel();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        self::$kernel = null;
    }
}
