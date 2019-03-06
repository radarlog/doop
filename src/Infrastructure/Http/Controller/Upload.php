<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Domain\Storage;
use Radarlog\S3Uploader\Infrastructure\Http\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;

final class Upload extends AbstractController implements Controller
{
    /** @var Storage */
    private $client;

    public function __construct(Storage $client)
    {
        $this->client = $client;
    }

    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        /** @var HttpFoundation\File\UploadedFile $file */
        $file = $request->files->get('image');

        $this->upload($file);

        return $this->redirect($this->generateUrl('index'));
    }

    private function upload(HttpFoundation\File\UploadedFile $file): void
    {
        $name = $file->getClientOriginalName();
        $content = file_get_contents($file->getRealPath());

        $image = new Image($name, $content);

        $this->client->upload($image);
    }
}
