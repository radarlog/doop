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
    private Query $query;

    private Storage $storage;

    public function __construct(Query $query, Storage $storage)
    {
        $this->query = $query;
        $this->storage = $storage;
    }

    /**
     * @throws \InvalidArgumentException
     * @throws NotFoundHttpException
     */
    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        $uuid = (string) $request->attributes->get('uuid');

        try {
            $result = $this->query->findOneHashNameByUuid($uuid);
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
