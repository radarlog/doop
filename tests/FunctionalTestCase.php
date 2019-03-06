<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests;

use Radarlog\S3Uploader\Kernel;
use Symfony\Bundle\FrameworkBundle;

class FunctionalTestCase extends FrameworkBundle\Test\WebTestCase
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
