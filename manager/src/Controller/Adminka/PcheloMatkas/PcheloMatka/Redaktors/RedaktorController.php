<?php

declare(strict_types=1);

namespace App\Controller\Adminka\PcheloMatkas\PcheloMatka\Redaktors;

use App\Annotation\Guid;


use App\Controller\ErrorHandler;
//use App\Model\Adminka\Entity\pcheloMatkas\DrevMatka\DrevMatka;
use App\Model\Adminka\UseCase\pcheloMatkas\pcheloMatka\Edit;
use App\Model\Adminka\UseCase\pcheloMatkas\pcheloMatka\Archive;
use App\Model\Adminka\UseCase\pcheloMatkas\pcheloMatka\Reinstate;
use App\Model\Adminka\UseCase\pcheloMatkas\pcheloMatka\Remove;


//use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use App\Model\Adminka\Entity\pcheloMatkas\pcheloMatka\pcheloMatka;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/pchelomatkas/pchelomatka/{pchelomatka_id}/redaktors", name="adminka.pchelomatkas.pchelomatka.redaktors")
 * @ParamConverter("pchelomatka", options={"id" = "pchelomatka_id"})
 */
class RedaktorController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param pcheloMatka $pchelomatka
     * @return Response
     */
    public function index(pcheloMatka $pchelomatka): Response
    {
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $pchelomatka);
        $periods = $pchelomatka->getPchelosezons();
        return $this->render('app/adminka/pchelomatkas/pchelomatka/redaktors/index.html.twig',
            compact('pchelomatka', 'periods'));
    }

    /**
     * @Route("/edit", name=".edit")
     * @param pcheloMatka $pchelomatka
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(pcheloMatka $pchelomatka, Request $request, Edit\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $pchelomatka);

        $command = Edit\Command::frompcheloMatka($pchelomatka);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors', ['pchelomatka_id' => $pchelomatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/pchelomatkas/pchelomatka/redaktors/edit.html.twig', [
            'pchelomatka' => $pchelomatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/archive", name=".archive", methods={"POST"})
     * @param pcheloMatka $pchelomatka
     * @param Request $request
     * @param Archive\Handler $handler
     * @return Response
     */
    public function archive(pcheloMatka $pchelomatka, Request $request, Archive\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors', ['id' => $pchelomatka->getId()]);
        }

//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $pchelomatka);

        $command = new Archive\Command($pchelomatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors', ['pchelomatka_id' => $pchelomatka->getId()]);
    }

    /**
     * @Route("/reinstate", name=".reinstate", methods={"POST"})
     * @param pcheloMatka $pchelomatka
     * @param Request $request
     * @param Reinstate\Handler $handler
     * @return Response
     */
    public function reinstate(pcheloMatka $pchelomatka, Request $request, Reinstate\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors', ['pchelomatka_id' => $pchelomatka->getId()]);
        }
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $pchelomatka);


        $command = new Reinstate\Command($pchelomatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors', ['pchelomatka_id' => $pchelomatka->getId()]);
    }

    /**
     * @Route("/delete", name=".delete", methods={"POST"})
     * @param pcheloMatka $pchelomatka
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(pcheloMatka $pchelomatka, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.settings', ['pchelomatka_id' => $pchelomatka->getId()]);
        }
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $pchelomatka);

        $command = new Remove\Command($pchelomatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.pchelomatkas');
    }
}