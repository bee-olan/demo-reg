<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Uchasties\Side;

use App\Annotation\Guid;

//use App\ReadModel\Proekt\Pasekas\Uchasties\Side\Filter;
//use App\ReadModel\Proekt\Pasekas\Uchasties\Side\SideFilterFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/app/proekts/pasekas/uchasties", name="app.proekts.pasekas.uchasties")
*/
class SideFilterController extends AbstractController
{
   private const PER_PAGE = 10;



//    /**
//     * @Route("", name="")
//     * @param Request $request
//     * @param SideFilterFetcher $fetcher
//     * @return Response
//     */
//    public function index(Request $request, SideFilterFetcher $fetcher): Response
//    {

//        $filter = new Filter\Filter;

//        $form = $this->createForm(Filter\Form::class, $filter);
//        $form->handleRequest($request);
// dd($form);
//        $pagination = $fetcher->all(
//            $filter,
//            $request->query->getInt('page', 1),
//            self::PER_PAGE,
//            $request->query->get('sort', 'name'),
//            $request->query->get('direction', 'asc')
//        );
// //dd($pagination);
//        return $this->render('app/proekts/pasekas/uchasties/index.html.twig', [
//            'pagination' => $pagination,
//            'form' => $form->createView(),
//        ]);
//    }

}
