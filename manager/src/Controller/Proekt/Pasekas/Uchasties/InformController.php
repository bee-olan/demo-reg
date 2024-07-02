<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Uchasties;

use App\Annotation\Guid;



//use App\ReadModel\Proekt\Pasekas\Uchasties\Side\SideFilterFetcher;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;

//use App\ReadModel\Adminka\Matkas\PlemMatka\DepartmentFetcher;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
//use App\ReadModel\Proekt\Pasekas\Uchasties\Side\Filter;
//use App\ReadModel\Proekt\Pasekas\Uchasties\Side\SideFilterFetcher;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\ErrorHandler;


/**
 * @Route("/app/proekt/pasekas/uchasties/spisok", name="app.proekts.pasekas.uchasties.spisok")
 */
class InformController extends AbstractController
{
    private const PER_PAGE = 10;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

//    /**
//     * @Route("", name="")
//     * @param Request $request
//     * @param SideFilterFetcher $fetcher
//     * @return Response
//     */
//    public function index(Request $request, SideFilterFetcher $fetcher): Response
//    {
//        $filter = new Filter\Filter();
//
//        $form = $this->createForm(Filter\Form::class, $filter);
//        $form->handleRequest($request);
//
//        $pagination = $fetcher->all(
//            $filter,
//            $request->query->getInt('page', 1),
//            self::PER_PAGE,
//            $request->query->get('sort', 'nike'),
//            $request->query->get('direction', 'asc')
//        );
////dd($pagination);
//        return $this->render('app/proekts/pasekas/uchasties/spisok/index.html.twig', [
//            'pagination' => $pagination,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/show/{id}", name=".show", requirements={"id"=Guid::PATTERN})
//     * @param Uchastie $uchastie
//     * @param DepartmentFetcher $fetcher
//     * @return Response
//     */
//    public function show(DepartmentFetcher $fetcher, Uchastie $uchastie): Response
//    {
//        $departments = $fetcher->allOfUchastie($uchastie->getId()->getValue());
//
//        return $this->render('app/proekts/pasekas/uchasties/spisok/show.html.twig',
//            compact('uchastie', 'departments'));
//    }


}

