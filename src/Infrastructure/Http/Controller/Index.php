<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Application\Query;
use Radarlog\S3Uploader\Infrastructure\Http\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;

final class Index extends AbstractController implements Controller
{
    /** @var Query\Image\FindAll */
    private $findAll;

    public function __construct(Query\Image\FindAll $findAll)
    {
        $this->findAll = $findAll;
    }

    // phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        return $this->render('base.html.twig', [
            'images' => $this->findAll->sortedByUploadDate(),
        ]);
    }
}
