<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure;

use Symfony\Bundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\HttpKernel;
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
}
