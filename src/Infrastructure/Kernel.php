<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure;

use Symfony\Bundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\WebpackEncoreBundle\WebpackEncoreBundle;

final class Kernel extends HttpKernel\Kernel
{
    use FrameworkBundle\Kernel\MicroKernelTrait;

    /**
     * @inheritdoc
     */
    public function registerBundles(): iterable
    {
        yield new FrameworkBundle\FrameworkBundle();
        yield new MonologBundle();
        yield new TwigBundle();
        yield new WebpackEncoreBundle();
    }

    /**
     * @inheritdoc
     */
    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import(sprintf('%s/config/{packages}/*.yaml', $this->getProjectDir()));
        $container->import(sprintf('%s/config/{packages}/%s/*.yaml', $this->getProjectDir(), $this->environment));
        $container->import(sprintf('%s/config/{services}.yaml', $this->getProjectDir()));
        $container->import(sprintf('%s/config/{services}_%s.yaml', $this->getProjectDir(), $this->environment));
    }

    /**
     * @inheritdoc
     */
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(sprintf('%s/config/routes.yaml', $this->getProjectDir()));
    }
}
