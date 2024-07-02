<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo\Oblast;

use App\Controller\ErrorHandler;
use App\Model\Comment\Entity\Comment\Comment;
use App\Model\Comment\UseCase\Comment\Edit;
use App\Model\Comment\UseCase\Comment\Remove;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\Model\Mesto\Entity\Okrugs\Okrug;
use App\Security\Voter\Comment\CommentAccess;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/proekts/mestos/{okrug_id}/comment", name="app.proekts.mestos.comment")
 * @ParamConverter("okrug", options={"id" = "okrug_id"})
 */
class CommentOblController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Okrug $okrug
     * @param Comment $comment
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request, Comment $comment, Okrug $okrug, Edit\Handler $handler): Response
    {
//       dd($okrug->getOblasts());
//        dd($oblast->getOkrug()->getName());
//        $this->denyAccessUnlessGranted(OblastAccess::VIEW, $oblast);
        $this->checkCommentIsForOblast($okrug, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = Edit\Command::fromComment($comment);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.mestos.oblasts', ['okrug_id' => $okrug->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/mestos/comment/edit.html.twig', [
            'okrug' => $okrug,
            'oblast' => $okrug->getOblasts(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Okrug $okrug
     * @param Comment $comment
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Okrug $okrug, Comment $comment, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete-comment', $request->request->get('token'))) {
            return $this->redirectToRoute('app.proekts.mestos.oblasts', ['okrug_id' => $okrug->getId()]);
        }

//        $this->denyAccessUnlessGranted(OblastAccess::VIEW, $oblast);
        $this->checkCommentIsForOblast($okrug, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = new Remove\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app.proekts.mestos.oblasts', ['okrug_id' => $okrug->getId()]);
    }

    private function checkCommentIsForOblast(Okrug $okrug, Comment $comment): void
    {
        if (!(
            $comment->getEntity()->getType() === Okrug::class &&
            $comment->getEntity()->getId() === $okrug->getId()->getValue()
        )) {
            throw $this->createNotFoundException();
        }
    }
}
