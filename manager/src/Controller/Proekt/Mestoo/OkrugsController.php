<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\ReadModel\Mesto\OkrugFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/mestos/okrugs ", name="app.proekts.mestos.okrugs")
 */
class OkrugsController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param OkrugFetcher $fetcher
     * @param MestoNomerFetcher $mestonomers
     * @return Response
     */
    public function okrugs(OkrugFetcher $fetcher, MestoNomerFetcher $mestonomers): Response
    {

        if ($mestonomers->exists($this->getUser()->getId())) {
            $this->addFlash('error', 'Ваш номер места расположения пасеки уже записан в БД');
            return $this->redirectToRoute('app.proekts.mestos.inform');
        }
        $okrugs = $fetcher->all();
        return $this->render('app/proekts/mestos/okrugs.html.twig', compact('okrugs'));
    }

}
