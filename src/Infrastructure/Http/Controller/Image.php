<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Http\Controller;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain\Storage;
use Radarlog\Doop\Infrastructure\Http\Controller;
use Radarlog\Doop\Infrastructure\Sql;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class Image extends AbstractController implements Controller
{
    private Query\Image\FindOne $findOne;

    private Storage $storage;

    public function __construct(Query\Image\FindOne $findOne, Storage $storage)
    {
        $this->findOne = $findOne;
        $this->storage = $storage;
    }

    /**
     * @throws \InvalidArgumentException
     * @throws NotFoundHttpException
     */
    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        $uuid = $request->attributes->get('uuid');

        try {
            $result = $this->findOne->hashNameById($uuid);
        } catch (Sql\NotFound $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        }

        $file = $this->storage->download($result->hash());

        $disposition = HeaderUtils::makeDisposition(HeaderUtils::DISPOSITION_ATTACHMENT, (string) $result->name());

        return new HttpFoundation\Response($file->content(), 200, [
            'Content-Type' => $file->format()->mime(),
            'Content-Length' => strlen($file->content()),
            'Content-Disposition' => $disposition,
        ]);
    }
}
