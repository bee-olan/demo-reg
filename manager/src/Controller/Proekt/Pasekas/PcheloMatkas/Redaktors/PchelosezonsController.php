<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PcheloMatkas\Redaktors;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;

use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\CreateTri;
use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\Create;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\ReadModel\Adminka\PcheloMatkas\PchelosezonFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/pchelomatkas/pchelomatka/{pchelomatka_id}/redaktors/pchelosezons", name="app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.pchelosezons")
 * @ParamConverter("pchelomatka", options={"id" = "pchelomatka_id"})
 */
class PchelosezonsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/createTri", name=".createTri")
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param PchelosezonFetcher $pcheloFets
     * @param CreateTri\Handler $handler
     * @return Response
     */
    public function createTri(PcheloMatka $pchelomatka, Request $request,
                              PchelosezonFetcher $pcheloFets,
                              CreateTri\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_MEMBERS, $pchelomatka);

        $hasPchelosezon = $pcheloFets->has($pchelomatka->getId()->getValue());

        if (!$hasPchelosezon) {
            try {
                $command = new CreateTri\Command($pchelomatka->getId()->getValue());
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.pchelovods.assign', ['pchelomatka_id' => $pchelomatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/redaktors/pchelosezons/createTri.html.twig');
    }

    /**
     * @Route("/create", name=".create")
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param PchelosezonFetcher $pcheloFets
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(PcheloMatka $pchelomatka, Request $request,
                           PchelosezonFetcher $pcheloFet,
                           Create\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(ElitMatkaAccess::MANAGE_MEMBERS, $pchelomatka);

        $maxPchelo = $pcheloFet->getMaxPchelo($pchelomatka->getId()->getValue());

        $command = new Create\Command($pchelomatka->getId()->getValue(), $maxPchelo);

        try {
            $handler->handle($command);
            return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.pchelovods.edit', ['pchelomatka_id' => $pchelomatka->getId()]);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/redaktors/pchelosezons/create.html.twig', [
            'pchelomatka' => $pchelomatka,
//            'form' => $form->createView(),
        ]);
    }


//    /**
//     * @Route("", name="")
//     * @param PcheloMatka $pchelomatka
//     * @param PchelosezonFetcher $pchelosezons
//     * @return Response
//     */
//    public function index(PcheloMatka $pchelomatka, PchelosezonFetcher $pchelosezons): Response
//    {
////        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_UCHASTIES, $pchelomatka);
////dd($pchelomatka->getId()->getValue());
//
//        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/redaktors/pchelosezons/index.html.twig', [
//            'pchelomatka' => $pchelomatka,
//            'pchelosezonss' => $pchelosezons->allOfPcheloMatka($pchelomatka->getId()->getValue()),
//        ]);
//    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
     * @param PcheloMatka $pchelomatka
     * @return Response
     */
    public function show(PcheloMatka $pchelomatka): Response
    {
        return $this->redirectToRoute('paseka.matkas.pchelomatka.redaktors.pchelosezons', ['pchelomatka_id' => $pchelomatka->getId()]);
    }
}
