<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure;

use Symfony\Bundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

final class Kernel extends HttpKernel\Kernel
{
    use FrameworkBundle\Kernel\MicroKernelTrait;

    private const CONFIG_EXTS = '.{yaml}';

    private const BUNDLES = [
        FrameworkBundle\FrameworkBundle::class => ['all' => true],
        MonologBundle::class => ['all' => true],
        TwigBundle::class => ['all' => true],
    ];

    /**
     * @inheritdoc
     */
    public function registerBundles(): iterable
    {
        foreach (self::BUNDLES as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->setParameter('container.dumper.inline_class_loader', true);

        $confDir = $this->getProjectDir() . '/config';

        $loader->load($confDir . '/packages/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/packages/' . $this->environment . '/**/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/services' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/services_' . $this->environment . self::CONFIG_EXTS, 'glob');
    }

    /**
     * @inheritdoc
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir() . '/config';

        $routes->import($confDir . '/{routes}/' . $this->environment . '/**/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}' . self::CONFIG_EXTS, '/', 'glob');
    }
}
