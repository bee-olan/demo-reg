<?php

declare(strict_types=1);

namespace App\Controller\Mesto\Okrugs;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Okrug;

use App\Model\Mesto\Entity\Okrugs\OkrugRepository;
use App\Model\Mesto\UseCase\Okrugs\Create;
use App\Model\Mesto\UseCase\Okrugs\Edit;
use App\Model\Mesto\UseCase\Okrugs\Remove;

use App\ReadModel\Mesto\OkrugFetcher;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/okrug", name="mesto.okrug")
 */
class OkrugController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/", name="")
     * @param OkrugFetcher $fetcher
     * @return Response
     */
    public function index(OkrugFetcher $fetcher): Response
    {
        $okrugs = $fetcher->all();
        return $this->render('app/mesto/okrug/index.html.twig', compact('okrugs'));
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
                return $this->redirectToRoute('mesto.okrug');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/mesto/okrug/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Okrug $okrug
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Okrug $okrug, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromOkrug($okrug);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('mesto.okrug.show', ['id' => $okrug->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/mesto/okrug/edit.html.twig', [
            'okrug' => $okrug,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Okrug $okrug
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Okrug $okrug, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('mesto.okrug.show', ['id' => $okrug->getId()]);
        }

        $command = new Remove\Command($okrug->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('mesto.okrug');
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('mesto.okrug.show', ['id' => $okrug->getId()]);
    }

    /**
     * @Route("/{id}", name=".show")
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('mesto.okrug');
    }
}
