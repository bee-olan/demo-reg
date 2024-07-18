<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Ras;
use App\Model\Drevos\UseCase\Rass\Create;
use App\Model\Drevos\UseCase\Rass\Edit;
use App\Model\Drevos\UseCase\Rass\Remove;
use App\ReadModel\Drevos\Rass\RasFetcher;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass", name="drevos.rass")
 */
// @IsGranted("ROLE_Adminka_MANAGE_MATERIS")

class RassController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param RasFetcher $fetcher
     * @return Response
     */
    public function index(RasFetcher $fetcher): Response
    {
       $rasas = $fetcher->allRods();
 //dd($rasas);      
  

        return $this->render('app/drevos/rass/index.html.twig',
                                compact('rasas'));
    }

    /**
     * @Route("/indbr", name=".indbr")
     * @param RasFetcher $fetcher
     * @return Response
     */
    public function indbr(RasFetcher $fetcher): Response
    {
        $rasas = $fetcher->all();
        //dd($rasas);


        return $this->render('app/drevos/rass/indbr.html.twig',
            compact('rasas'));
    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command();

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Ras $rasa
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Ras $rasa, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromRasa($rasa);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.show', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/edit.html.twig', [
            'rasa' => $rasa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Ras $rasa
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Ras $rasa, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.show', ['id' => $rasa->getId()]);
        }

        $command = new Remove\Command($rasa->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('drevos.rass');
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.show', ['id' => $rasa->getId()]);
    }

    /**
     * @Route("/{id}", name=".show" , requirements={"id"=Guid::PATTERN})
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('drevos.rass');
    }
}
