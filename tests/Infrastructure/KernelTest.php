<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure;

use Radarlog\S3Uploader\Tests\FunctionalTestCase;
use Symfony\Component\Config\Loader\LoaderInterface;

class KernelTest extends FunctionalTestCase
{
    public function testRegisterBundles(): void
    {
        self::assertCount(3, self::$kernel->getBundles());
    }

    public function testBuild(): void
    {
        $loader = $this->createMock(LoaderInterface::class);

        self::$kernel->registerContainerConfiguration($loader);

        self::assertTrue(self::$container->getParameter('container.dumper.inline_class_loader'));
    }
}
