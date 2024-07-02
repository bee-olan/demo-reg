<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Uchasties;

use App\Controller\ErrorHandler;
use App\ReadModel\Adminka\Uchasties\GroupFetcher;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/app/proekts/pasekas/uchasties/groupas", name="app.proekts.pasekas.uchasties.groupas")
 */
class GroupasController extends AbstractController
{
    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param GroupFetcher $fetcher
     * @return Response
     */
    public function index(GroupFetcher $fetcher): Response
    {
        $groups = $fetcher->all();
//dd($groups);
        return $this->render('app/proekts/pasekas/uchasties/groupas/index.html.twig', compact('groups'));
    }

}
