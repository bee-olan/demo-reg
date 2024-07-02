<?php

declare(strict_types=1);

namespace App\Controller\Mesto\Okrugs\Oblasts\Raions;

use App\Model\Mesto\UseCase\Okrugs\Oblasts\Raions\Create;
use App\Model\Mesto\UseCase\Okrugs\Oblasts\Raions\Edit;
use App\Model\Mesto\UseCase\Okrugs\Oblasts\Raions\Remove;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Id;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\Annotation\Guid;

use App\ReadModel\Mesto\Oblasts\Raions\RaionFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/okrug/oblast/{id}/raion", name="mesto.okrug.oblast.raion")
 */
class RaionController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/", name="")
     * @param Oblast $oblast
     * @param RaionFetcher $raions
     * @return Response
     */
    public function index(Oblast $oblast, RaionFetcher $raions): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

        return $this->render('app/mesto/okrug/oblast/raion/index.html.twig', [
            'oblast' => $oblast,
            'raions' => $raions->allOfOblast($oblast->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Oblast $oblast
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Oblast $oblast, Request $request, Create\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);
        $command = new Create\Command($oblast->getId()->getValue());
        $command->mesto = $oblast->getMesto();

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $handler->handle($command);

                return $this->redirectToRoute('mesto.okrug.oblast.raion', ['id' => $oblast->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/mesto/okrug/oblast/raion/create.html.twig', [
            'oblast' => $oblast,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{raion_id}/edit", name=".edit")
     * @param Oblast $oblast
     * @param string $raion_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Oblast $oblast, string $raion_id, Request $request, Edit\Handler $handler): Response
    {
        // $this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);


        $raion = $oblast->getRaion(new Id($raion_id));

        $command = Edit\Command::fromRaion($oblast, $raion);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('mesto.okrug.oblast.raion.show', ['id' => $oblast->getId(), 'raion_id' => $raion_id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/mesto/okrug/oblast/raion/edit.html.twig', [
            'oblast' => $oblast,
            'raion' => $raion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{raion_id}/delete", name=".delete", methods={"POST"})
     * @param Oblast $oblast
     * @param string $raion_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Oblast $oblast, string $raion_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(OblastAccess::MANAGE_MEMBERS, $oblast);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('mesto.okrug.oblast.raion', ['id' => $oblast->getId()]);
        }

        $raion = $oblast->getRaion(new Id($raion_id));

        $command = new Remove\Command($oblast->getId()->getValue(), $raion->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('mesto.okrug.oblast.raion', ['id' => $oblast->getId()]);
    }

    /**
     * @Route("/{raion_id}", name=".show", requirements={"raion_id"=Guid::PATTERN}))
     * @param Oblast $oblast
     * @return Response
     */
    public function show(Oblast $oblast): Response
    {
        return $this->redirectToRoute('mesto.okrug.oblast.raion', ['id' => $oblast->getId()]);
    }
}