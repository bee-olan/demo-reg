<?php

declare(strict_types=1);

namespace App\Controller\Proekt;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseProController extends AbstractController
{
    /**
     * @Route("/app/proekts/basepro", name="app.proekts.basepro")
     * @return Response
     */
    public function basepro(): Response
    {

        return $this->render('app/proekts/basepro.html.twig');
    }
}
