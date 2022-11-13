<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Http\Controller;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Infrastructure\Http\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class Image extends AbstractController implements Controller
{
    private readonly Query $query;

    private readonly Domain\Storage $storage;

    public function __construct(Query $query, Domain\Storage $storage)
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
            $file = $this->storage->download($result->hash());
        } catch (Domain\Image\NotFound $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        }

        $disposition = HeaderUtils::makeDisposition(HeaderUtils::DISPOSITION_ATTACHMENT, (string) $result->name());

        return new HttpFoundation\Response($file->content(), 200, [
            'Content-Type' => $file->format()->mime(),
            'Content-Length' => strlen($file->content()),
            'Content-Disposition' => $disposition,
        ]);
    }
}
