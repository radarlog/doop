<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader;

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

    private function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }

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
        /**
         * This can drastically improve DX by reducing the time to load classes when the DebugClassLoader is enabled.
         * If you're using FrameworkBundle, this performance improvement will also impact the "dev" environment:
         *
         * @link https://github.com/symfony/symfony/blob/3.4/UPGRADE-3.4.md
         * @link https://twitter.com/nicolasgrekas/status/929032213815005184
         */
        $container->setParameter('container.dumper.inline_class_loader', true);

        $confDir = $this->getConfigDir();

        $loader->load($confDir . '/packages/*' . self::CONFIG_EXTS, 'glob');

        if (is_dir($confDir . '/packages/' . $this->environment)) {
            $loader->load($confDir . '/packages/' . $this->environment . '/**/*' . self::CONFIG_EXTS, 'glob');
        }

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
