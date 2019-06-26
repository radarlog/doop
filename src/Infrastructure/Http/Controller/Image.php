<?php
declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Http\Controller;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain\Storage;
use Radarlog\Doop\Infrastructure\Http\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\HeaderUtils;

final class Image extends AbstractController implements Controller
{
    /** @var Query\Image\FindOne */
    private $findOne;

    /** @var Storage */
    private $storage;

    public function __construct(Query\Image\FindOne $findOne, Storage $storage)
    {
        $this->findOne = $findOne;
        $this->storage = $storage;
    }

    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        $uuid = $request->attributes->get('uuid');

        $result = $this->findOne->hashNameByUuid($uuid);

        $file = $this->storage->download($result->hash());

        $disposition = HeaderUtils::makeDisposition(HeaderUtils::DISPOSITION_ATTACHMENT, $result->name());

        return new HttpFoundation\Response($file->content(), 200, [
            'Content-Type' => $file->format()->mime(),
            'Content-Length' => strlen($file->content()),
            'Content-Disposition' => $disposition,
        ]);
    }
}
