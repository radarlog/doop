<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure;

use Radarlog\Doop\Infrastructure\Kernel;
use Radarlog\Doop\Tests\FunctionalTestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpFoundation\Request;

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

        self::assertInstanceOf(Kernel::class, self::$kernel);
        self::assertTrue(self::$container->getParameter('container.dumper.inline_class_loader'));
    }

    public function testRoutes(): void
    {
        $request = Request::create('/');

        $response = self::$kernel->handle($request);

        self::assertSame(200, $response->getStatusCode());
    }
}
