<?php

declare(strict_types=1);

namespace App\Controller\Adminka\PcheloMatkas\PcheloMatka\Redaktors;

use App\Annotation\Guid;

use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelovod;
use  App\Model\Adminka\Entity\Uchasties\Uchastie\Id ;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/pchelomatkas/pchelomatka/{pchelomatka_id}/redaktors/pchelovods", name="adminka.pchelomatkas.pchelomatka.redaktors.pchelovods")
 * @ParamConverter("pchelomatka", options={"id" = "pchelomatka_id"})
 */
class PchelovodsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param PcheloMatka $pchelomatka
     * @return Response
     */
    public function index(PcheloMatka $pchelomatka): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_MEMBERS, $pchelomatka);

        return $this->render('app/adminka/pchelomatkas/pchelomatka/redaktors/pchelovods/index.html.twig', [
            'pchelomatka' => $pchelomatka,
            'pchelovods' => $pchelomatka->getPchelovods(),
        ]);
    }

    /**
     * @Route("/assign", name=".assign")
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param Pchelovod\Add\Handler $handler
     * @return Response
     */
    public function assign(PcheloMatka $pchelomatka, Request $request, Pchelovod\Add\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_MEMBERS, $pchelomatka);

        if (!$pchelomatka->getPchelosezons() ) {
            $this->addFlash('error', 'Add pchelosezons before adding pchelovods.');
            return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors.pchelovods', ['pchelomatka_id' => $pchelomatka->getId()]);
        }

        $command = new Pchelovod\Add\Command($pchelomatka->getId()->getValue());

        $form = $this->createForm(Pchelovod\Add\Form::class, $command, ['pchelomatka' => $pchelomatka->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors.pchelovods', ['pchelomatka_id' => $pchelomatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/pchelomatkas/pchelomatka/redaktors/pchelovods/assign.html.twig', [
            'pchelomatka' => $pchelomatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uchastie_id}/edit", name=".edit")
     * @param PcheloMatka $pchelomatka
     * @param string $uchastie_id
     * @param Request $request
     * @param Pchelovod\Edit\Handler $handler
     * @return Response
     */
    public function edit(PcheloMatka $pchelomatka, string $uchastie_id, Request $request, Pchelovod\Edit\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_MEMBERS, $pchelomatka);

        $pchelovod = $pchelomatka->getPchelovod(new Id($uchastie_id));

        $command = Pchelovod\Edit\Command::fromPchelovod($pchelomatka, $pchelovod);

        $form = $this->createForm(Pchelovod\Edit\Form::class, $command, ['pchelomatka' => $pchelomatka->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors.pchelovods', ['pchelomatka_id' => $pchelomatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/pchelomatkas/pchelomatka/redaktors/pchelovods/edit.html.twig', [
            'pchelomatka' => $pchelomatka,
            'pchelovod' => $pchelovod,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uchastie_id}/revoke", name=".revoke", methods={"POST"})
     * @param PcheloMatka $pchelomatka
     * @param string $uchastie_id
     * @param Request $request
     * @param Pchelovod\Remove\Handler $handler
     * @return Response
     */
    public function revoke(PcheloMatka $pchelomatka, string $uchastie_id, Request $request, Pchelovod\Remove\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_MEMBERS, $pchelomatka);

        if (!$this->isCsrfTokenValid('revoke', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktor.pchelosezons', ['pchelomatka_id' => $pchelomatka->getId()]);
        }

        $command = new Pchelovod\Remove\Command($pchelomatka->getId()->getValue(), $uchastie_id);

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors.pchelovods', ['pchelomatka_id' => $pchelomatka->getId()]);
    }

    /**
     * @Route("/{uchastie_id}", name=".show", requirements={"uchastie_id"=Guid::PATTERN}))
     * @param PcheloMatka $pchelomatka
     * @return Response
     */
    public function show(PcheloMatka $pchelomatka): Response
    {
        return $this->redirectToRoute('adminka.pchelomatkas.pchelomatka.redaktors.pchelovods',
            ['pchelomatka_id' => $pchelomatka->getId()]);
    }
}
