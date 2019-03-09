<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Application\Command;
use Radarlog\S3Uploader\Infrastructure\Http\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;

final class Upload extends AbstractController implements Controller
{
    /** @var Command\Bus */
    private $bus;

    public function __construct(Command\Bus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        /** @var HttpFoundation\File\UploadedFile $file */
        $file = $request->files->get('image');

        $name = $file->getClientOriginalName();
        $content = file_get_contents($file->getRealPath());

        $command = new Command\Image\Upload($name, $content);

        $this->bus->execute($command);

        return $this->redirect($this->generateUrl('index'));
    }
}
