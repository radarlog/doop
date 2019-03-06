<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Infrastructure\Http\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;

final class Index extends AbstractController implements Controller
{
    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        return $this->render('base.html.twig');
    }
}
