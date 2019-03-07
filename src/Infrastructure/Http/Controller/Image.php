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
        $key = $request->attributes->get('key');

        $image = $this->client->get($key);

        $disposition = HeaderUtils::makeDisposition(HeaderUtils::DISPOSITION_ATTACHMENT, $image->name());

        $response = new HttpFoundation\Response($image->content(), 200, [
            'Content-Type' => $image->format()->mime(),
            'Content-Length' => strlen($image->content()),
            'Content-Disposition' => $disposition,
        ]);

        return $response;
    }
}
