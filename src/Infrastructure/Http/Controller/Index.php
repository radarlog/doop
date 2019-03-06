<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Http\Controller;

use Radarlog\S3Uploader\Infrastructure\Http\Controller;
use Radarlog\S3Uploader\Infrastructure\S3\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;

final class Index extends AbstractController implements Controller
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        $images = iterator_to_array($this->client->list());

        return $this->render('base.html.twig', [
            'images' => $images,
        ]);
    }
}
