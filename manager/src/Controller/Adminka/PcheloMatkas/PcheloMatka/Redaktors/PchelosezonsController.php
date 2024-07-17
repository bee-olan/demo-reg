<?php

declare(strict_types=1);

namespace App\Controller\Adminka\PcheloMatkas\PcheloMatka\Redaktors;

use App\Annotation\Guid;
use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\Create;
use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\Edit;
use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\Remove;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Id ;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\ReadModel\Adminka\PcheloMatkas\PchelosezonFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Controller\ErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/pchelomatkas/pchelomatka/{pchelomatka_id}/redaktor/periods", name="adminka.pchelomatkas.pchelomatka.redaktor.periods")
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
     * @Route("", name="")
     * @param PcheloMatka $pchelomatka
     * @param PchelosezonFetcher $periodFets
     * @return Response
     */
    public function index(PcheloMatka $pchelomatka, PchelosezonFetcher $periodFets): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_MEMBERS, $pchelomatka);
//dd($periods->allOfPcheloMatka($pchelomatka->getId()->getValue()));
        return $this->render('app/adminka/pchelomatkas/pchelomatka/redaktors/periods/index.html.twig', [
            'pchelomatka' => $pchelomatka,
            'periods' => $periodFets->allOfPcheloMatka($pchelomatka->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param PchelosezonFetcher $periodFets
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(PcheloMatka $pchelomatka, Request $request,
                           PchelosezonFetcher $periodFets,
                           Create\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_MEMBERS, $pchelomatka);
      $maxPchelosezon = $periodFets->getMaxPchelo($pchelomatka->getId()->getValue());
        $command = new Create\Command($pchelomatka->getId()->getValue(), $maxPchelosezon);

//        $form = $this->createForm(Create\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktor.periods', ['pchelomatka_id' => $pchelomatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
//        }

        return $this->render('app/adminka/pchelomatkas/pchelomatka/redaktor/periods/create.html.twig', [
            'pchelomatka' => $pchelomatka,
//            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param PcheloMatka $pchelomatka
     * @param string $id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(PcheloMatka $pchelomatka, string $id, Request $request, Edit\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_MEMBERS, $pchelomatka);

        $period = $pchelomatka->getPchelosezon(new Id($id));

        $command = Edit\Command::fromPchelosezon($pchelomatka, $period);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktor.periods.show', ['pchelomatka_id' => $pchelomatka->getId(), 'id' => $id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/pchelomatkas/pchelomatka/redaktor/periods/edit.html.twig', [
            'pchelomatka' => $pchelomatka,
            'period' => $period,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param PcheloMatka $pchelomatka
     * @param string $id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(PcheloMatka $pchelomatka, string $id, Request $request, Remove\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_MEMBERS, $pchelomatka);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktor.periods', ['pchelomatka_id' => $pchelomatka->getId()]);
        }

        $period = $pchelomatka->getPchelosezon(new Id($id));

        $command = new Remove\Command($pchelomatka->getId()->getValue(), $period->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktor.periods', ['pchelomatka_id' => $pchelomatka->getId()]);
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
     * @param PcheloMatka $pchelomatka
     * @return Response
     */
    public function show(PcheloMatka $pchelomatka): Response
    {
        return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktor.periods', ['pchelomatka_id' => $pchelomatka->getId()]);
    }
}
