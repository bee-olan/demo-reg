<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\Annotation\Guid;

use App\ReadModel\User\UserFetcher;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\Model\Mesto\Entity\InfaMesto\Id;
use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//use App\Security\Voter\Rabota\U4astniki\OkrugAccess;
use App\Controller\ErrorHandler;


/**
 * @Route("/app/proekts/mestos", name="app.proekts.mestos")
 */
class InformController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


	/**
     * @Route("/inform", name=".inform")
     * @return Response
     * @param MestoNomerFetcher $fetchers
     * @param UserFetcher $users
     */
    public function inform(MestoNomerFetcher $fetchers, UserFetcher $users): Response
    {
       
// dd($this->getUser());
        $user = $users->get($this->getUser()->getId());
        $last = $user->getName()->getLast();
        $fetcher = $fetchers->allMestNom();

        //$mestonomer = $mestonomers ->get(new Id($this->getUser()->getId()));

        $mestonomer = $fetchers ->find($this->getUser()->getId());


        return $this->render('/app/proekts/mestos/inform.html.twig',
                                compact('fetcher', 'mestonomer', 'last'));
    }

    //     /**
    //  * @Route("/show", name=".show")
    //  * @param MestoNomerFetcher $fetchers
    //  * @param MestoNomerRepository $mestonomers
    //  * @return Response
    //  */
    // public function show(MestoNomerFetcher $fetchers, MestoNomerRepository $mestonomers,
    //                      Request $request ): Response
    // {
    //     $fetcher = $fetchers->allMestNom();

    //     $mestonomer = $mestonomers ->get(new Id($this->getUser()->getId()));


    //     return $this->render('proekt/mestos/show.html.twig',
    //         compact('fetcher', 'mestonomer'));

    // }

}
