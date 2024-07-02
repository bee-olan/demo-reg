<?php

declare(strict_types=1);

namespace App\Controller\Mesto;



use App\ReadModel\Adminka\Matkas\Actions\ActionFetcher;
use App\ReadModel\Adminka\Matkas\Actions\Filter;
use App\ReadModel\Mesto\OkrugFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/actions", name="mesto.actions")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ActionMestosController extends AbstractController
{
    private const PER_PAGE = 50;

    private $actions;

    public function __construct(ActionFetcher $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param OkrugFetcher $fetchers
     * @return Response
     */
    public function index(Request $request, OkrugFetcher $fetchers): Response
    {
        $zajavkis = $fetchers->allZajavkas();
//        dd($zajavkis);
//        if ($this->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
//            $filter = Filter::all();
//        } else {
//            $filter = Filter::all()->forUchastie($this->getUser()->getId());
//        }
//dd($filter);
//        $pagination = $this->actions->all(
//            $filter,
//            $request->query->getInt('page', 1),
//            self::PER_PAGE
//        );

        return $this->render('app/mesto/actions.html.twig', [

            'zajavkis' => $zajavkis,
        ]);
    }
}
