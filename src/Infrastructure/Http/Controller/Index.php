<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Http\Controller;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Infrastructure\Http;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation;

final class Index extends AbstractController implements Http\Controller
{
    readonly private Query $query;

    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    // phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response
    {
        $form = $this->createForm(Http\Form\UploadType::class);

        return $this->render('base.html.twig', [
            'images' => $this->query->findAllSortedByUploadDate(),
            'form' => $form->createView(),
        ]);
    }
}
