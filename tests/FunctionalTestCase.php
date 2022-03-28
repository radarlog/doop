<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

// phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
class FunctionalTestCase extends KernelTestCase
{
    use Fixtures;

    protected function setUp(): void
    {
        parent::setUp();

        self::$kernel = self::bootKernel();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        self::ensureKernelShutdown();
    }
}
