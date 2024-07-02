<?php

declare(strict_types=1);

namespace App\Controller\Adminka;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/adminka", name="adminka")
     * @return Response
     */
    public function index(): Response
    {
        return $this->redirectToRoute('adminka.uchasties');
    }
}
