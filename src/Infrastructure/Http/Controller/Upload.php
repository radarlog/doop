<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Http\Controller;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Infrastructure\Http;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class Upload extends AbstractController implements Http\Controller
{
    private Command\Bus $bus;

    public function __construct(Command\Bus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        $form = $this->createForm(Http\Form\UploadType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var HttpFoundation\File\UploadedFile $file */
            $file = $form->getData();

            $name = (string) $file->getClientOriginalName();
            $content = file_get_contents($file->getRealPath());

            $command = new Command\Image\Upload($name, $content);

            $this->bus->execute($command);
        }

        return $this->redirect($this->generateUrl('index'));
    }
}
