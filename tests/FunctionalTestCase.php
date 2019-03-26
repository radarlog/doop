<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests;

use Radarlog\S3Uploader\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FunctionalTestCase extends KernelTestCase
{
    use FixtureTrait;

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
