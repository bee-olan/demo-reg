<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\Annotation\Guid;

use App\Model\Comment\UseCase\Comment;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\ReadModel\Mesto\Oblasts\Raions\CommentRaiFetcher;
use App\ReadModel\Mesto\Oblasts\Raions\RaionFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/mestos/{oblast_id}", name="app.proekts.mestos")
 * @ParamConverter("oblast", options={"id" = "oblast_id"})
 */
class RaionsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/raions", name=".raions")
     * @param Request $request
     * @param Oblast $oblast
     * @param RaionFetcher $raions
     * @param CommentRaiFetcher $comments
     * @param Comment\AddMesto\Handler $commentHandler
     * @return Response
     */
    public function raions(Request $request,
                           Oblast $oblast,
                           CommentRaiFetcher $comments,
                           RaionFetcher $raions,
                           Comment\AddMesto\Handler $commentHandler
                            ): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

        $commentCommand = new Comment\AddMesto\Command(
            $this->getUser()->getId(),
            Oblast::class,
            $oblast->getId()->getValue()
        );
        $commentForm = $this->createForm(Comment\AddMesto\Form::class, $commentCommand);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            try {
                $commentHandler->handle($commentCommand);
                return $this->redirectToRoute('app.proekts.mestos.raions', ['oblast_id' => $oblast->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/mestos/raions.html.twig', [
            'okrug' => $oblast->getOkrug(),
            'oblast' => $oblast,
            'raions' => $raions->allOfOblast($oblast->getId()->getValue()),
            'comments' => $comments->allForRaion($oblast->getId()->getValue()),
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
