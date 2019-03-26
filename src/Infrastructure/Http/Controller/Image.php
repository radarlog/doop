<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Domain\Storage;
use Radarlog\S3Uploader\Infrastructure\Http\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\HeaderUtils;

final class Image extends AbstractController implements Controller
{
    /** @var Storage */
    private $client;

    public function __construct(Storage $client)
    {
        $this->client = $client;
    }

    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        $hash = $request->attributes->get('hash');

        $file = $this->client->get($hash);

        $disposition = HeaderUtils::makeDisposition(HeaderUtils::DISPOSITION_ATTACHMENT, $file->hash());

        return new HttpFoundation\Response($file->content(), 200, [
            'Content-Type' => $file->format()->mime(),
            'Content-Length' => strlen($file->content()),
            'Content-Disposition' => $disposition,
        ]);
    }
}
