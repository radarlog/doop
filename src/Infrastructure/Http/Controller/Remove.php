<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Http\Controller;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Infrastructure\Http;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;

final class Remove extends AbstractController implements Http\Controller
{
    readonly private Command\Bus $bus;

    public function __construct(Command\Bus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        $uuid = (string) $request->attributes->get('uuid');

        $command = new Command\Image\Remove($uuid);

        $this->bus->execute($command);

        return $this->redirect($this->generateUrl('index'));
    }
}
